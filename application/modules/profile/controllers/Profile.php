<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->lang->load('auth');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			// redirect to the login page
			redirect('login', 'refresh');
		} else {
			$user = $this->ion_auth->user()->row();
			$group = $this->ion_auth->get_users_groups()->row();

			$data = array(
				'judul' => "User",
				'deskripsi' => "Profile",
			);

			$data['user'] = $user;
			$data['group'] = $group;

			$data['first_name'] = array(
				'name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'First Name',
				'value' => $user->first_name,
			);
			$data['last_name'] = array(
				'name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Last Name',
				'value' => $user->last_name,
			);
			$data['username'] = array(
				'name' => 'username',
				'id' => 'username',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Username',
				'value' => $user->username,
			);
			$data['company'] = array(
				'name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Company Name',
				'value' => $user->company,
			);
			$data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Email',
				'value' => $user->email,
			);
			$data['phone'] = array(
				'name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Phone Number',
				'value' => $user->phone,
			);
			$data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'class' => 'form-control',
				'disabled' => 'disabled',
				'placeholder' => 'Password',
			);
			$data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'class' => 'form-control',
				'disabled' => 'disabled',
				'placeholder' => 'Confirm Password',
			);

			$data['csrf'] = $this->_get_csrf_nonce();
			$this->template->load('template', 'profile/index', $data);
		}
	}

	// user profile
	function update($id)
	{
		$this->_rules();

		$user = $this->ion_auth->user($id)->row();

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required');
			}
		}

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('message', trim_str(validation_errors()));
			$this->session->set_flashdata('type', 'error');
			redirect('profile', 'refresh');
		} else {
			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'password' => $this->input->post('password'),
			);

			if ($this->ion_auth->update($user->id, $data)) {
				$this->session->set_flashdata('message', trim_str($this->ion_auth->messages()));
				$this->session->set_flashdata('type', 'success');
				redirect('profile', 'refresh');
			} else {
				$this->session->set_flashdata('message', trim_str($this->ion_auth->errors()));
				$this->session->set_flashdata('type', 'error');
				redirect('profile', 'refresh');
			}
		}
	}

	// user images
	function image($id)
	{
		$user = $this->ion_auth->user($id)->row();
		$rand_name = 'user_' . random_string('alnum', 10); // create random image name

		$config['upload_path'] = './assets/upload/img/';
		$config['file_name'] = $rand_name;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['remove_spaces'] = TRUE;
		$config['max_size'] = 1024 * 1;
		$config['max_height'] = 1024;
		$config['max_width'] = 1024;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('foto')) {
			$this->session->set_flashdata('message', trim_str($this->upload->display_errors()));
			$this->session->set_flashdata('type', 'error');

			redirect('profile', 'refresh');
		} else {
			$img_path = './assets/upload/img/';
			$img_name = $user->img_name;

			if (!empty($img_name)) // is user image empty?
			{
				// if no, delete existing user image
				unlink($img_path . $img_name);

				// upload & replace with new image
				$data = array('upload_data' => $this->upload->data());
				$image = $data['upload_data']['file_name'];
			} else {
				// if yes, just upload new image
				$data = array('upload_data' => $this->upload->data());
				$image = $data['upload_data']['file_name'];
			}
		}

		$data = array('img_name' => $image);
		$result = $this->ion_auth->update($user->id, $data);

		if ($result) {
			$this->session->set_flashdata('message', 'Image Updated Successfully');
			$this->session->set_flashdata('type', 'success');
			redirect('profile', 'refresh');
		} else {
			$this->session->set_flashdata('message', 'Image Updated Failed');
			$this->session->set_flashdata('type', 'error');
			redirect('profile', 'refresh');
		}
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('username', 'Uername', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
	}
}

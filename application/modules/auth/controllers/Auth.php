<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->library('email');
		$this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));

		// Include the google api php libraries
		// $this->load->model('google_oauth_model'); // modular model
		$this->load->config('auth/google_config'); // modular config
		$this->load->config('auth/email'); // modular email

		include_once APPPATH . "libraries/Google/Google_Client.php";
		include_once APPPATH . "libraries/Google/contrib/Google_Oauth2Service.php";
	}

	// redirect if needed, otherwise display the user list
	function index()
	{
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect to the home if not admin
			redirect('home', 'refresh');
		} else {
			// set the flash data error message if there is one
			$data['message'] = toastr_warning_msg(trim_str(validation_errors()));

			//list the users
			$data['users'] = $this->ion_auth->users()->result();
			$data['judul'] = "User";
			$data['deskripsi'] = "Management";
			foreach ($data['users'] as $k => $user) {
				$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->template->load('template', 'auth/index', $data);
		}
	}

	// log the user in
	function login()
	{
		ob_start();
		$data['judul'] = "Login";
		$data['deskripsi'] = "CIA HMVC";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true) {
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			// check by email
			$login = $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember);
			if (!$login) {
				$this->ion_auth_model->identity_column = 'username';

				// check by username
				$login = $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember);
			}

			if ($login) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', trim_str($this->ion_auth->messages()));
				$this->session->set_flashdata('type', 'success');
				redirect('home', 'refresh');
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', trim_str($this->ion_auth->errors()));
				$this->session->set_flashdata('type', 'error');
				redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {

			// Google Project API Credentials
			// get item value from modular config
			$clientId     = $this->config->item('google_client_id');
			$clientSecret = $this->config->item('google_secret_id');
			$redirectUrl  = $this->config->item('google_call_back');

			// Google Client Configuration
			$client = new Google_Client();
			$client->setApplicationName('CIA HMVC');
			$client->setClientId($clientId);
			$client->setClientSecret($clientSecret);
			$client->setRedirectUri($redirectUrl);
			$oAuth2 = new Google_Oauth2Service($client);

			if (isset($_REQUEST['code'])) {
				$client->authenticate();
				$this->session->set_userdata('token', $client->getAccessToken());
				redirect($redirectUrl);
			}
			$token = $this->session->userdata('token');
			if (!empty($token)) {
				$client->setAccessToken($token);
			}
			if ($client->getAccessToken()) {
				$userProfile = $oAuth2->userinfo->get();
				// pass oAuth2 data to array $data
				$data = array(
					'oauth_provider'	=> 'google',
					'username'			=> strtolower($userProfile['given_name']),
					'first_name'		=> $userProfile['given_name'],
					'last_name'			=> $userProfile['family_name'],
					'email'				=> $userProfile['email'],
					'img_name'			=> $userProfile['picture'],
					'authURL'			=> $client->createAuthUrl() // Google Login URL
				);

				// pass oAuth2 data to session 'google'
				$this->session->set_userdata('google', $data);

				// get email from google
				$identity = $data['email'];

				// is Google login true or false ?
				$google_login = $this->ion_auth->google_login($identity);

				if ($google_login) {
					// set flashdata for success alerts
					$this->session->set_flashdata('message', trim_str($this->ion_auth->messages()));
					$this->session->set_flashdata('type', 'success');

					// redirect them back to the home page
					redirect('home', 'refresh');
				} else {
					// if FALSE then show error based on it's condition
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					$this->session->set_flashdata('type', 'error');
					$this->clear();
				}
			}
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$data['message'] = warning_msg(trim_str(validation_errors()));
			$data['identity'] = array(
				'name' => 'identity',
				'id'    => 'identity',
				'class' => 'form-control',
				'placeholder' => 'Email / Username',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array(
				'name' => 'password',
				'id'   => 'password',
				'type' => 'password',
				'class' => 'form-control',
				'placeholder' => 'Password',
			);
			$data['authURL'] = $client->createAuthUrl(); // Google Login URL
		}
		$this->_render_page('auth/login', $data);
	}

	// register google account
	function register()
	{
		$data['judul'] = "Register";
		$data['deskripsi'] = "CIA HMVC";

		// get oAuth data from session 'google'
		$google = $this->session->userdata('google');
		$users = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();

		if (isset($google)) {

			$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required');

			if ($this->form_validation->run() == true) {
				if ($google) {
					$img_src = $google['img_name']; // image source url from ggoogle
					$img_path = './assets/upload/img/';
					$img_name = 'google_' . random_string('alnum', 10) . '.jpg'; // create random image name
					$img_dest = $img_path . $img_name;

					// saving image from google to image folder
					file_put_contents($img_dest, file_get_contents($img_src));

					$data = array(
						'first_name'	=> $google['first_name'],
						'last_name'		=> $google['last_name'],
						'username'		=> strtolower($google['first_name']),
						'email'			=> $google['email'],
						'img_name'		=> $img_name,
						'activation'	=> 0
					);

					$identity = $data['email'];
					$password = $this->input->post('password');
					$email = $data['email'];

					// registering google account
					$this->ion_auth->google_register($identity, $password, $email, $data);

					/* Auto Registration
					// $this->Google_oauth_model->register($identity, $password, $email, $data);
					// notification if success
					// $this->session->set_flashdata('message', 'Account is successfully registered!');
					// $this->session->set_flashdata('type', 'success');
					redirect('home', 'refresh');
					*/
				} else {

					$this->session->set_flashdata('message', trim_str($this->ion_auth->errors()));
					$this->session->set_flashdata('type', 'error');
					redirect('registration');
				}
			} else {
				// pass the user to the view
				$data['message'] = warning_msg(trim_str(validation_errors()));

				$data['images'] = $google['img_name'];
				$data['identity'] = array('identity' => $google['email']);
				$data['first_name'] = array('first_name' => $google['first_name']);
				$data['last_name'] = array('last_name' => $google['last_name']);
				$data['active'] = $users['active'];
				$data['img_name'] = array(
					'name'  => 'img_name',
					'id'    => 'img_name',
					'type'  => 'text',
					'class' => 'form-control',
					'readonly' => 'readonly',
					'value' => $google['img_name'],
				);
				$data['password'] = array(
					'name' => 'password',
					'id'   => 'password',
					'type' => 'password',
					'class' => 'form-control',
					'placeholder' => 'Password',
				);
				$data['password_confirm'] = array(
					'name' => 'password_confirm',
					'id'   => 'password_confirm',
					'type' => 'password',
					'class' => 'form-control',
					'placeholder' => 'Confirm Password',
				);
			}

			$this->_render_page('auth/register', $data);
		} else {
			redirect('login', 'refresh');
		}
	}

	function activation_user($id, $active_code)
	{
		// get oAuth data from session 'google'
		$google = $this->session->userdata('google');
		$users = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();

		if ($active_code == $users['active_code']) {
			$activation_user = $this->ion_auth->google_activate($id);
		} else {
			redirect('activation', 'refresh');
		}

		if ($activation_user) {
			// Email notif
			$email_content = '<h2>Hello, <b>' . ucfirst($users['first_name']) . ' ' . ucfirst($users['last_name']) . '</b></h2>';
			$email_content .= '<p>Thank you, your account has been <b>activated</b> !<br>';
			$email_content .= 'Enjoy and have a nice day!</p>';
			email_send($users['email'], 'Activation Completed', $email_content);

			$this->session->set_flashdata('message', trim_str($this->ion_auth->messages()));
			$this->session->set_flashdata('type', 'success');
			redirect('home', 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', trim_str($this->ion_auth->errors()));
			$this->session->set_flashdata('type', 'error');
			redirect('login', 'refresh');
		}
	}

	function activation()
	{
		$data['judul'] = "Activation";
		$data['deskripsi'] = "CIA HMVC";

		// get oAuth data from session 'google'
		$google = $this->session->userdata('google');

		if (isset($google)) {

			$this->form_validation->set_rules('active_code', 'Activation Code', 'required');
			$users = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();

			$id = $users['id'];
			$active_code = $users['active_code'];
			$code = $this->input->post('active_code');

			if ($this->form_validation->run() == true) {
				if ($code == $active_code || $active_code == 1) {
					$this->ion_auth->google_activate($id);

					// Email notif
					$email_content = '<h2>Hello, <b>' . ucfirst($users['first_name']) . ' ' . ucfirst($users['last_name']) . '</b></h2>';
					$email_content .= '<p>Thank you, your account has been <b>activated</b> !<br>';
					$email_content .= 'You can now sign in using your <b>Google Account</b></p>';
					email_send($users['email'], 'Activation Completed', $email_content);

					// notification if success
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->session->set_flashdata('type', 'success');
					redirect('activation');
				} else {
					// notification if failed
					$this->session->set_flashdata('message', 'The Activation Code is invalid');
					$this->session->set_flashdata('type', 'error');
					redirect('activation');
				}
			} else {
				// validation notification
				$data['message'] = warning_msg(trim_str(validation_errors()));

				// pass the user to the view
				$data['authURL'] = $google['authURL']; // Google Login URL
				$data['identity'] = $users['email'];
				$data['activation'] = $users['activation'];
				$data['id'] = $users['id'];
				$data['active_code'] = array(
					'name' => 'active_code',
					'id'   => 'active_code',
					'type' => 'text',
					'class' => 'form-control',
					'placeholder' => 'Activation Code',
					'value' => $code,
				);
				$this->_render_page('auth/activation', $data);
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	function generate($id)
	{
		$data['title'] = "Generate Code";

		// get oAuth data from session 'google'
		$google = $this->session->userdata('google');

		if (isset($google)) {
			$users = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();

			$id = $users['id'];
			if ($users['activation'] == 1) {
				redirect('home', 'refresh');
			} else {
				$this->ion_auth->generate_activation($id);

				// Get new code
				$new_code = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();;

				$email_content = '<h2>Hello, <b>' . ucfirst($users['first_name']) . ' ' . ucfirst($users['last_name']) . '</b></h2>';
				$email_content .= '<p>Below is the the <i>activation code</i> that you just requested</p>';
				$email_content .= '<h3><b>' . $new_code['active_code'] . '</b></h3>';
				$email_content .= '<p>You can paste the code to the activation page</p>';
				$email_content .= '<p><b>- OR -</b></p>';
				$email_content .= '<p>You can click URL below to activate and login directly<br>';
				$email_content .= '<b>' . anchor('activation/user/' . $users['id'] . '/' . $new_code['active_code']) . '</b></p>';

				email_send($users['email'], 'Activation Code Request', $email_content);

				// notification if sgenerate uccess
				$this->session->set_flashdata('message', 'New Code code has been sent to your email at <b>' . $users['email'] . '</b><br>Please check your <b>inbox</b> !');
				$this->session->set_flashdata('type', 'success');
				redirect('activation');
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	// cancel google register
	function clear()
	{
		$this->session->unset_userdata('token');
		$this->session->unset_userdata('google');
		ob_end_clean();
		redirect('login', 'refresh');
	}

	// log the user out
	function logout()
	{
		$data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		if ($logout) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('type', 'success');
		} else {
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->session->set_flashdata('type', 'error');
		}

		$this->session->unset_userdata('token');
		$this->session->unset_userdata('google');
		$this->session->unset_userdata('userData');

		ob_end_clean();
		redirect('login', 'refresh');
	}

	// change password
	function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false) {
			// display the form
			// set the flash data error message if there is one
			$data['message'] = (trim_str(validation_errors())) ? trim_str(validation_errors()) : $this->session->flashdata('message');

			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
			);
			$data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
			);
			$data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			// render
			$this->_render_page('auth/change_password', $data);
		} else {
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change) {
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	// forgot password
	function forgot_password()
	{
		// setting validation rules by checking wheather identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false) {
			$data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
			);

			if ($this->config->item('identity', 'ion_auth') != 'email') {
				$data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			} else {
				$data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$data['message'] = (trim_str(validation_errors())) ? trim_str(validation_errors()) : $this->session->flashdata('message');
			$this->_render_page('auth/forgot_password', $data);
		} else {
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity)) {

				if ($this->config->item('identity', 'ion_auth') != 'email') {
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				} else {
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten) {
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('login', 'refresh'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code) {
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user) {
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false) {
				// display the form

				// set the flash data error message if there is one
				$data['message'] = (trim_str(validation_errors())) ? trim_str(validation_errors()) : $this->session->flashdata('message');

				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
				);
				$data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
				);
				$data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$data['csrf'] = $this->_get_csrf_nonce();
				$data['code'] = $code;

				// render
				$this->_render_page('auth/reset_password', $data);
			} else {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));
				} else {
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change) {
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect('login', 'refresh');
					} else {
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		} else {
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	// activate the user
	function activate($id, $code = false)
	{
		if ($code !== false) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('type', 'success');
			redirect('users', 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->session->set_flashdata('type', 'error');
			redirect("auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	function deactivate($id = NULL)
	{
		// do we have the right userlevel?
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$deactivate = $this->ion_auth->deactivate($id);
		}

		if ($deactivate) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('type', 'success');
		} else {
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->session->set_flashdata('type', 'error');
		}

		// redirect them back to the auth page
		redirect('users', 'refresh');
	}

	// create a new user
	function create_user()
	{
		if (!$this->ion_auth->logged_in()) {
			// redirect to auth
			redirect('users', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) {
			// redirect to home
			redirect('home', 'refresh');
		}

		$data['title'] = "Create User";
		$data['judul'] = "User";
		$data['deskripsi'] = "Create";

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$data['identity_column'] = $identity_column;

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('username', $this->lang->line('create_user_validation_username_label'), 'required');

		if ($identity_column !== 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
		} else {
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
		$this->form_validation->set_rules(
			'password',
			$this->lang->line('create_user_validation_password_label'),
			'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]'
		);
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true) {
			$email    = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');

			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'username'    => $this->input->post('username'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
			);

			// check to see if we are creating the user
			$this->ion_auth->register($identity, $password, $email, $data);

			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('type', 'success');

			// redirect them back to the admin page
			redirect('users', 'refresh');
		} else {
			// display the create user form
			// set the flash data error message if there is one
			$data['message'] = toastr_warning_msg(trim_str(validation_errors()));

			$data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$data['identity'] = array(
				'name'  => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$data['username'] = array(
				'name'  => 'username',
				'id'    => 'username',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('username'),
			);
			$data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$data['password_confirm'] = array(
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->template->load('template', 'auth/create_user', $data);
		}
	}

	// read a user
	function read_user($id)
	{
		$data['title'] = "View User";
		$data['judul'] = "User";
		$data['deskripsi'] = "View";

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
			// redirect to the access error page if not admin
			$data = array(
				'judul' => 'Error',
				'deskripsi' => 'Access'
			);
			$this->template->load('template', 'errors/html/error_access', $data);
		}

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// pass the user to the view
		$data['user'] = $user;
		$data['groups'] = $groups;
		$data['currentGroups'] = $currentGroups;

		// pass the user to the view
		$data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'class' => 'form-control',
			'readonly' => 'readonly',
			'value' => $user->first_name,
		);
		$data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'class' => 'form-control',
			'readonly' => 'readonly',
			'value' => $user->last_name,
		);
		$data['username'] = array(
			'name'  => 'username',
			'id'    => 'username',
			'type'  => 'text',
			'class' => 'form-control',
			'readonly' => 'readonly',
			'value' => $user->username,
		);
		$data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'class' => 'form-control',
			'readonly' => 'readonly',
			'value' => $user->company,
		);
		$data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'class' => 'form-control',
			'readonly' => 'readonly',
			'value' => $user->phone,
		);
		$data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'text',
			'class' => 'form-control',
			'readonly' => 'readonly',
			'value' => $user->email,
		);

		$this->template->load('template', 'auth/read_user', $data);
	}

	// edit a user
	function edit_user($id)
	{
		$data['title'] = "Edit User";
		$data['judul'] = "User";
		$data['deskripsi'] = "Edit";

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
			// redirect to the access error page if not admin
			$data = array(
				'judul' => 'Error',
				'deskripsi' => 'Access'
			);
			$this->template->load('template', 'errors/html/error_access', $data);
		}

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required');
		$this->form_validation->set_rules('username', $this->lang->line('edit_user_validation_username_label'), 'required');

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE) {
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'username'	 => $this->input->post('username'),
					'email'      => $this->input->post('email'),
					'phone'      => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password')) {
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin()) {
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}

				// check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data)) {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->session->set_flashdata('type', 'success');

					if ($this->ion_auth->is_admin() || $this->ion_auth->logged_in()) {
						if ($this->ion_auth->is_admin()) {
							redirect('user/edit/' . $user->id);
						} else {
							redirect('home', 'refresh');
						}
					} else {
						$this->session->set_flashdata('type', 'error');
						redirect('users', 'refresh');
					}
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					$this->session->set_flashdata('type', 'error');

					if ($this->ion_auth->is_admin()) {
						redirect('users', 'refresh');
					} else {
						redirect('/', 'refresh');
					}
				}
			}
		}

		// display the edit user form
		$data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$data['message'] = toastr_warning_msg(trim_str(validation_errors()));

		// pass the user to the view
		$data['user'] = $user;
		$data['groups'] = $groups;
		$data['currentGroups'] = $currentGroups;

		$data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'class' => 'form-control',
			'placeholder' => 'First Name',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'class' => 'form-control',
			'placeholder' => 'Last Name',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$data['username'] = array(
			'name'  => 'username',
			'id'    => 'username',
			'type'  => 'text',
			'class' => 'form-control',
			'placeholder' => 'Username',
			'value' => $this->form_validation->set_value('username', $user->username),
		);
		$data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'class' => 'form-control',
			'placeholder' => 'Company Name',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'text',
			'class' => 'form-control',
			'placeholder' => 'Email',
			'value' => $this->form_validation->set_value('email', $user->email),
		);
		$data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'class' => 'form-control',
			'placeholder' => 'Phone Number',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
			'class' => 'form-control',
			'placeholder' => 'Password',
		);
		$data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
			'class' => 'form-control',
			'placeholder' => 'Confirm Password',
		);
		$this->template->load('template', 'auth/edit_user', $data);
	}

	// list groups
	function group_list()
	{

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			// redirect to the access error page if not admin
			$data = array(
				'judul' => 'Error',
				'deskripsi' => 'Access'
			);
			$this->template->load('template', 'errors/html/error_access', $data);
		} else {
			// list the groups
			$data['groups'] = $this->ion_auth->groups()->result();
			$data['judul'] = "Group";
			$data['deskripsi'] = "Management";

			$this->template->load('template', 'auth/list_group', $data);
		}
	}

	// read a user
	function read_group($id)
	{
		$data['title'] = "View Group";
		$data['judul'] = "Group";
		$data['deskripsi'] = "View";

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
			// redirect to the access error page if not admin
			$data = array(
				'judul' => 'Error',
				'deskripsi' => 'Access'
			);
			$this->template->load('template', 'errors/html/error_access', $data);
		}

		$user_groups = $this->ion_auth->group($id)->row();

		// pass the user to the view
		$data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'class' => 'form-control',
			'readonly' => 'readonly',
			'value' => $user_groups->name,
		);
		$data['description'] = array(
			'name'  => 'description',
			'id'    => 'description',
			'type'  => 'text',
			'class' => 'form-control',
			'readonly' => 'readonly',
			'value' => $user_groups->description,
		);

		$this->template->load('template', 'auth/read_group', $data);
	}

	// create a new group
	function create_group()
	{
		$data['title'] = $this->lang->line('create_group_title');
		$data['judul'] = "Group";
		$data['deskripsi'] = "Create";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			// redirect to the access error page if not admin
			$data = array(
				'judul' => 'Error',
				'deskripsi' => 'Access'
			);
			$this->template->load('template', 'errors/html/error_access', $data);
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE) {
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id) {
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->session->set_flashdata('type', 'success');
				redirect('groups', 'refresh');
			}
		} else {
			// display the create group form
			// set the flash data error message if there is one
			$data['message'] = toastr_warning_msg(trim_str(validation_errors()));

			$data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->template->load('template', 'auth/create_group', $data);
		}
	}

	// edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id)) {
			redirect('users', 'refresh');
		}

		$data['title'] = $this->lang->line('edit_group_title');
		$data['judul'] = "Group";
		$data['deskripsi'] = "Edit";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			// redirect to the access error page if not admin
			$data = array(
				'judul' => 'Error',
				'deskripsi' => 'Access'
			);
			$this->template->load('template', 'errors/html/error_access', $data);
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST)) {
			if ($this->form_validation->run() === TRUE) {
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if ($group_update) {
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
					$this->session->set_flashdata('type', 'success');
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					$this->session->set_flashdata('type', 'error');
				}
				redirect('groups', 'refresh');
			}
		}

		// set the flash data error message if there is one
		$data['message'] = toastr_warning_msg(trim_str(validation_errors()));

		// pass the user to the view
		$data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'class' => 'form-control',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->template->load('template', 'auth/edit_group', $data);
	}

	// delete a group
	function delete_group($id)
	{
		// do we have the right userlevel?
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
			// redirect to the access error page if not admin
			$data = array(
				'judul' => 'Error',
				'deskripsi' => 'Access'
			);
			$this->template->load('template', 'errors/html/error_access', $data);
		} else {
			if ($this->ion_auth->is_admin()) {
				$this->ion_auth->delete_group($id);
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->session->set_flashdata('type', 'success');
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$this->session->set_flashdata('type', 'error');
			}
			// redirect them back to the auth page
			redirect('groups', 'refresh');
		}
	}

	// delete a user
	function delete_user($id)
	{
		$user = $this->ion_auth->user($id)->row();

		// do we have the right userlevel?
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
			// redirect to the access error page if not admin
			$data = array(
				'judul' => 'Error',
				'deskripsi' => 'Access'
			);
			$this->template->load('template', 'errors/html/error_access', $data);
		} else {
			if ($this->ion_auth->is_admin()) {
				$img_path = './assets/upload/img/';
				$img_name = $user->img_name;

				if (!empty($img_name)) // is user image empty?
				{
					// if no, delete existing user image
					unlink($img_path . $img_name);
				}

				$delete = $this->ion_auth->delete_user($id);
				if ($delete) {
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->session->set_flashdata('type', 'success');
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					$this->session->set_flashdata('type', 'error');
				}
				redirect('users', 'refresh');
			}
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
		if (
			$this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')
		) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function _render_page($view, $data = null, $returnhtml = false) //I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html; //This will return html on 3rd argument being true
	}
}

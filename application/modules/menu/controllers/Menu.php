<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->library('form_validation');
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect to the login page
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template','errors/html/error_access', $data);
        }
        else
        {
            $menu = $this->Menu_model->get_all_self_join();

            $data = array(
                'judul' => 'Menu',
                'deskripsi' => 'Page',
                'menu_data' => $menu
            );
            $this->template->load('template','menu/menu_list', $data);
        }
    }

    public function read_menu($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template','errors/html/error_access', $data);
        }
        else
        {
            $row = $this->Menu_model->get_by_id_self_join($id);
            if ($row)
            {
            $data = array(
                'judul' => 'Menu',
                'deskripsi' => 'View',
			    'id' => $row->id,
			    'name' => $row->name,
			    'url' => $row->url,
			    'icon' => $row->icon,
			    'active' => $row->active,
			    'is_admin' => $row->is_admin,
			    'parent_name' => $row->parent_name,
			    );
            $this->template->load('template','menu/menu_read', $data);
            } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            $this->session->set_flashdata('type', 'error');
            redirect(site_url('menu'));
            }
        }
    }

    public function create_menu()
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template','errors/html/error_access', $data);
        }
        else
        {
            $data = array(
            'judul' => 'Menu',
            'deskripsi' => 'Create',
            'method' => 'POST',
            'button' => 'Create',
            'action' => site_url('menu/create_action_menu'),
		    'id' => set_value('id'),
		    'name' => set_value('name'),
		    'url' => set_value('url'),
		    'icon' => set_value('icon'),
		    'active' => set_value('active'),
		    'is_admin' => set_value('is_admin'),
		    'parent' => set_value('parent'),
			);
        }
        $this->template->load('template','menu/menu_form', $data);
    }

    public function create_action_menu()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', trim_str(validation_errors()));
            $this->session->set_flashdata('type', 'error');
            $this->create_menu();
            redirect(site_url('menu/create_menu'));
        } else {
            $data = array(
		    'name' => $this->input->post('name',TRUE),
		    'url' => $this->input->post('url',TRUE),
		    'icon' => $this->input->post('icon',TRUE),
		    'active' => $this->input->post('active',TRUE),
		    'is_admin' => $this->input->post('is_admin',TRUE),
		    'parent' => $this->input->post('parent',TRUE),
		    );

            $this->Menu_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            $this->session->set_flashdata('type', 'success');
            redirect(site_url('menu'));
        }
    }

    public function update_menu($id)
    {
        $row = $this->Menu_model->get_by_id($id);
        if (!$this->ion_auth->logged_in())
        {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template','errors/html/error_access', $data);
        }
        elseif ($row)
        {
            $data = array(
            'judul' => 'Menu',
            'deskripsi' => 'Edit',
            'method' => 'POST',
            'button' => 'Update',
            'action' => site_url('menu/update_action_menu'),
		    'id' => set_value('id', $row->id),
		    'name' => set_value('name', $row->name),
		    'url' => set_value('url', $row->url),
		    'icon' => set_value('icon', $row->icon),
		    'active' => set_value('active', $row->active),
		    'is_admin' => set_value('is_admin', $row->is_admin),
		    'parent' => set_value('parent', $row->parent),
		    );
            $this->template->load('template','menu/menu_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            $this->session->set_flashdata('type', 'error');
            redirect(site_url('menu'));
        }
    }

    public function update_action_menu()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', trim_str(validation_errors()));
            $this->session->set_flashdata('type', 'error');
            $this->update_menu($this->input->post('id', TRUE));
            redirect(site_url('menu/update_menu/'.$this->input->post('id', TRUE)));
        } else {
            $data = array(
		    'name' => $this->input->post('name',TRUE),
		    'url' => $this->input->post('url',TRUE),
		    'icon' => $this->input->post('icon',TRUE),
		    'active' => $this->input->post('active',TRUE),
		    'is_admin' => $this->input->post('is_admin',TRUE),
		    'parent' => $this->input->post('parent',TRUE),
		    );

            $this->Menu_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            $this->session->set_flashdata('type', 'success');
            redirect(site_url('menu'));
        }
    }

    public function delete_menu($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template','errors/html/error_access', $data);
        }
        else
        {
            $row = $this->Menu_model->get_by_id($id);

            if ($row) {
                $this->Menu_model->delete($id);
                $this->session->set_flashdata('message', 'Delete Record Success');
                $this->session->set_flashdata('type', 'success');
                redirect(site_url('menu'));
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
                $this->session->set_flashdata('type', 'error');
                redirect(site_url('menu'));
            }
        }
    }

    public function activate($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template','errors/html/error_access', $data);
        }
        else
        {
            $row = $this->Menu_model->get_by_id($id);
            $data = array(
                'active' => 1,
            );

            if ($row) {
                $this->Menu_model->update($id, $data);
                $this->session->set_flashdata('message', 'Menu Activated');
                $this->session->set_flashdata('type', 'success');
                redirect(site_url('menu'));
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                $this->session->set_flashdata('type', 'error');
                redirect(site_url('menu'));
            }
        }
    }

    public function deactivate($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template','errors/html/error_access', $data);
        }
        else
        {
            $row = $this->Menu_model->get_by_id($id);
            $data = array(
                'active' => 0,
            );

            if ($row) {
                $this->Menu_model->update($id, $data);
                $this->session->set_flashdata('message', 'Menu Dectivated');
                $this->session->set_flashdata('type', 'success');
                redirect(site_url('menu'));
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                $this->session->set_flashdata('type', 'error');
                redirect(site_url('menu'));
            }
        }
    }

    public function _rules()
    {
	    $this->form_validation->set_rules('name', 'name', 'trim|required');
	    $this->form_validation->set_rules('url', 'url', 'trim|required');
	    $this->form_validation->set_rules('icon', 'icon', 'trim|required');
	    $this->form_validation->set_rules('active', 'active', 'trim|required|numeric');
	    $this->form_validation->set_rules('parent', 'parent', 'trim|required|numeric');
	    $this->form_validation->set_rules('id', 'id', 'trim');
	}

}
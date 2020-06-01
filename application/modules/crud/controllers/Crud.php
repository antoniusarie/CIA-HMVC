
<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Crud_model');

        // Load another module and use its controller/models & method/functions
        $this->load->module('menu');

        $this->load->library('form_validation');
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
    }

    function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template', 'errors/html/error_access', $data);
        } else {

            $data = array(
                'judul'         => "CRUD",
                'deskripsi'     => "Generator",
                'action'        => base_url('crud/execute'),
            );

            $data['table_name'] = $this->Crud_model->list_tables();
            $data['controller'] = array(
                'name'  => 'controllers',
                'id'    => 'controllers',
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Controller Name',
                'value' => '',
            );
            $data['model'] = array(
                'name'  => 'models',
                'id'    => 'models',
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Model Name',
                'value' => '',
            );
            $data['view_title'] = array(
                'name'  => 'views',
                'id'    => 'views',
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Page Title',
                'value' => '',
            );
            $data['view_subtitle'] = array(
                'name'  => 'views_subtitle',
                'id'    => 'views_subtitle',
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Page Subtitle',
                'value' => '',
            );
            $data['icon'] = array(
                'type' => 'text',
                'class' => 'form-control iconpicker',
                'data-input-search' => 'true',
                'data-placement' => 'bottomRight',
                'data-component' => '.input-group-append, .input-group-prepend',
                'name' => 'icon',
                'id' => 'icon',
                'placeholder' => 'Icon Menu',
                'style' => 'cursor:pointer',
            );
            $data['is_admin'] = array(
                'name'  => 'is_admin',
                'id'    => 'is_admin',
                'type'  => 'checkbox',
                'value' => 1
            );
            $data['crud'] = array(
                'name'  => 'crud',
                'id'    => 'crud',
                'class' => 'form-horizontal',
            );
        }
        $this->template->load('template', 'crud/index', $data);
    }

    function execute()
    {
        $data = array(
            'judul'         => "CRUD",
            'deskripsi'     => "Generator",
        );

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', trim_str(validation_errors()));
            $this->session->set_flashdata('type', 'error');

            redirect('crud', 'refresh');
        } else {

            // get form data
            $data_crud = array(
                'table_name'     => $this->input->post('table_name'),
                'controller'     => $this->input->post('controllers'),
                'model'          => $this->input->post('models'),
                'view'           => $this->input->post('views'),
                'view_subtitle'  => $this->input->post('views_subtitle'),
                'is_admin'       => $this->input->post('is_admin')
            );

            // Also add and activate related menu according to table menu
            $data_menu = array(
                'name' => $this->input->post('table_name'),
                'url' => $this->input->post('table_name'),
                'icon' => $this->input->post('icon'),
                'active' => 1,
                'is_admin' => 0,
                'parent' => 0
            );

            $this->Menu_model->insert($data_menu); // insert data into db menu

            // Generate CRUD
            $this->generate($data_crud);
            $this->session->set_flashdata('message', 'Generate CRUD Success');
            $this->session->set_flashdata('type', 'success');

            // redirect
            redirect('crud', 'refresh');
        }
        $this->template->load('template', 'crud/index', $data);
    }

    function generate($data_crud)
    {
        if (isset($data_crud['table_name'])) {
            // set data
            $table_name = $data_crud['table_name'];

            $c = ucfirst($data_crud['controller']);
            $m = ucfirst($data_crud['model']);
            $j = ucfirst($data_crud['view']);
            $d = ucfirst($data_crud['view_subtitle']);

            $v_list = $table_name . "_list";
            $v_read = $table_name . "_read";
            $v_form = $table_name . "_form";

            // url
            $c_url = strtolower($c);
            $j_url = strtolower($j);
            $d_url = strtolower($d);

            // filename
            $c_file = $c . '.php';
            $m_file = $m . '.php';

            $v_list_file = $v_list . '.php';
            $v_read_file = $v_read . '.php';
            $v_form_file = $v_form . '.php';

            // target folder
            $target = "./application/modules/";

            // modules path
            $path = APPPATH . "modules/";

            $pk = $this->Crud_model->primary_field($table_name);
            $non_pk = $this->Crud_model->not_primary_field($table_name);
            $all = $this->Crud_model->all_field($table_name);

            // create / delete folder
            if (is_dir($path . $c_url) == true) {
                delete_recursive($path . $c_url);
                mkdir($path . $c_url . "/controllers/", 0777, true);
                mkdir($path . $c_url . "/models/", 0777, true);
                mkdir($path . $c_url . "/views/", 0777, true);
            } else {
                mkdir($path . $c_url . "/controllers/", 0777, true);
                mkdir($path . $c_url . "/models/", 0777, true);
                mkdir($path . $c_url . "/views/", 0777, true);
            }

            // generate
            if (empty($data_crud['is_admin'])) {
                include $path . "crud/core/generate_controller.php";
            } else {
                include $path . "crud/core/generate_admin_controller.php";
            }
            include $path . "crud/core/generate_model.php";
            include $path . "crud/core/generate_view_list.php";
            include $path . "crud/core/generate_view_form.php";
            include $path . "crud/core/generate_view_read.php";

            $data = array(
                'controller'   => $result_controller,
                'model'        => $result_model,
                'view_list'    => $result_view_list,
                'view_form'    => $result_view_form,
                'view_read'    => $result_view_read
            );

            $this->session->set_flashdata('crud', $data);
            $this->session->set_flashdata('message', 'Generate Success');
            $this->session->set_flashdata('type', 'success');
            redirect('crud', 'refresh');
        } else {
            $this->session->set_flashdata('message', 'no table selected');
            $this->session->set_flashdata('type', 'error');
            redirect('crud', 'refresh');
        }
    }

    function setting()
    {
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {
            // redirect them to the home page because they must be an administrator to view this
            // return show_error('You must be an administrator to view this page.');
            $data = array(
                'judul'         => "CRUD",
                'deskripsi'     => "Setting",
            );
            $this->template->load('template', 'errors/html/error_access', $data);
        }

        $this->template->load('template', 'crud/core/setting', $data);
    }

    function _rules()
    {
        // validate form input
        $this->form_validation->set_rules('table_name', 'Table Name', 'required');
        $this->form_validation->set_rules('controllers', 'Controller', 'required');
        $this->form_validation->set_rules('models', 'Models', 'required');
        $this->form_validation->set_rules('views', 'Views', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
    }
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
	var $template_data = array();

	function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	function load($template = NULL, $view = NULL, $data = array())
	{
		$this->ci = &get_instance();

		$this->set('meta', $this->ci->load->view('layout/meta', $data, TRUE));
		$this->set('css', $this->ci->load->view('layout/css', $data, TRUE));
		$this->set('js', $this->ci->load->view('layout/js', $data, TRUE));
		$this->set('header', $this->ci->load->view('layout/header', $data, TRUE));
		$this->set('nav', $this->ci->load->view('layout/nav', $data, TRUE));
		$this->set('sidebar', $this->ci->load->view('layout/sidebar', $data, TRUE));
		$this->set('content_header', $this->ci->load->view('layout/content_header', $data, TRUE));
		$this->set('plugins', $this->ci->load->view('layout/plugins', $data, TRUE));
		$this->set('footer', $this->ci->load->view('layout/footer', $data, TRUE));

		$this->set('contents', $this->ci->load->view($view, $data, TRUE));	// contents from CRUD Generator	

		$this->ci->load->view('layout/template', $this->template_data, FALSE);
	}
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */

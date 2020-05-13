<?php defined('BASEPATH') or exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{
	protected $data = array();

	public function __construct()
	{
		date_default_timezone_set('Asia/Jakarta');
		parent::__construct();
		$this->load->helper(array('url', 'form', 'file', 'directory', 'language', 'string', 'path', 'cookie', 'date'));
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */

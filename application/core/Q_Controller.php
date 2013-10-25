<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Q_Messages.php';

class Q_Controller extends CI_Controller {

	private $_name;
	private $_messages;
	protected $layout;
	protected $pageTitle;

	public function __construct($name = null) {
		parent::__construct();
		// session_start();
		
		$this->layout = 'layouts/index';
		$this->page_title = 'Quanta';
		$this->module_name = 'Quanta Module';
		$this->_name = $name;
		if(isset($name))
			$this->load->model($name.'_model');
		$this->_messages = new Q_Messages();
	}

	public function render($view = 'layouts/home', $data = array()){
		$this->load->view($this->layout, array('view' => $view, 'data' => $data), false);
	}
	
	public function add_error($title = 'An error occurred.', $body = '') 
	{
		// echo 'gothere!'; die();
		$this->_messages->add_error($title, $body);
	}
	
	public function add_success($title = 'Operation successful.', $body = '') 
	{
		$this->_messages->add_success($title, $body);
	}
	
	public function add_warning($title = 'Warning', $body = '') 
	{
		$this->_messages->add_warning($title, $body);
	}
	
	public function has_errors() 
	{
		return $this->_messages->has_errors();
	}
}

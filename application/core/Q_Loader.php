<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Q_Messages.php';

class Q_Loader extends CI_Loader {

	private $_messages;
	
	function __construct(){
		parent::__construct();
		$this->_messages = new Q_Messages();
	}

	public function success_message()  {
		$success_messages = $this->_messages->success_message();
		$this->load->view('layouts/success_message', compact('success_messages'));
	}
	
	public function error_message() {
		$error_messages = $this->_messages->error_message();
		$this->load->view('layouts/error_message', compact('error_messages'));
	}
	
	public function warning_message() {
		$warning_messages = $this->_messages->warning_message();
		$this->load->view('layouts/warning_message', compact('warning_messages'));
	}

	public function all_messages()  {
		$this->success_message();
		$this->error_message();
		$this->warning_message();
	}
	
	public function get_error_message() {
		return($this->_messages->error_message());
	
	}
	public function get_warning_message() {
		return($this->_messages->warning_message());
	
	}
	public function get_success_message() {
		return($this->_messages->success_message());
	}
}


?>
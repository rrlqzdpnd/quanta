<?php

class Q_Messages {
	
	private $_CI_instance;

	public function __construct() {	
		$this->_CI_instance =& get_instance();
	}
	
	public function add_error($title = 'An error occurred.', $body = '')
	{
		$error_messages = $this->_CI_instance->phpsession->get('messages', 'error');
		if(!isset($error_messages)) 
		{
			$error_messages = array();
		}
		if(!isset($error_messages[$title])) 
		{
			$error_messages[$title] = array();
		}
		$error_messages[$title][] = $body;
		
		$this->_CI_instance->phpsession->save('messages', $error_messages, 'error');
		// echo 'got here!'; die(); 
	}
	
	public function shit(){
		echo 'got here'; die();
	}
	
	public function add_success($title = 'Operation successful.', $body = '') 
	{
		$success_messages = $this->_CI_instance->phpsession->get('messages', 'success');
		if(!isset($success_messages)) {
			$success_messages = array();
		}
		if(!isset($success_messages[$title])) {
			$success_messages[$title] = array();
		}
		$success_messages[$title][] = $body;
		$this->_CI_instance->phpsession->save('messages', $success_messages, 'success');
	}
	
	public function add_warning($title = 'Warning', $body = '') 
	{
		$warning_messages = $this->_CI_instance->phpsession->get('messages', 'warning');
		if(!isset($warning_messages)) {
			$warning_messages = array();
		}
		if(!isset($warning_messages[$title])) {
			$warning_messages[$title] = array();
		}
		$warning_messages[$title][] = $body;
		$this->_CI_instance->phpsession->save('messages', $warning_messages, 'warning');
	}
	
	public function has_errors() 
	{
		$error = $this->_CI_instance->phpsession->get('messages', 'error');
		return isset($error);
	}
	
	public function success_message() 
	{
		$messages = $this->_CI_instance->phpsession->get('messages', 'success');
		// clear errors from session
		$this->_CI_instance->phpsession->clear('messages','success');
		
		return $messages;
	}
	
	public function error_message() 
	{

		$messages = $this->_CI_instance->phpsession->get('messages', 'error');
		// clear errors from session
		$this->_CI_instance->phpsession->clear('messages','error');

		return $messages;
	}
	
	public function warning_message() 
	{
		$messages = $this->_CI_instance->phpsession->get('messages', 'warning');
		// clear errors from session
		$this->_CI_instance->phpsession->clear('messages','warning');

		return $messages;
	}
	
	public function all_messages() {
		$this->success_message();
		$this->error_message();
		$this->warning_message();
	}
}


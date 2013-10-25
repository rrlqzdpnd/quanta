<?php

class Home extends Q_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
        $data['title'] = "Quanta - Practice college entrance tests and get instant results!";
		//If the user is not logged in:
		// They should not be able to access other pages other than the ones in auth.
		// Redirect to landing page.
		if(!isset($_SESSION['userid']))
        {
			$this->render('layouts/home', $data);
		}
		//If the user is logged in, layouts/home should be dashboard/index
		else
        {
            if($_SESSION['usertype'] == 1):
                redirect('admin/dashboard/index');
            else:
                redirect('user/dashboard/index');
            endif;
		}
	}
}

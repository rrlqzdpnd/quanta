<?

class Profile extends Q_Controller {
	
	function __construct() {
		// echo 'here!'; die();
        parent::__construct('Profile');
    }

	public function index(){
		$userinfo = $this->Profile_model->getUser($_SESSION['userid']);
		$this->render('profile/index', compact('userinfo'));
	}
	
	public function edit(){
				
		if(empty($_POST['inputOldPassword']) && !empty($_POST['inputNewPassword'])){
			$this->add_error('Oh snap!', 'You need to input your old password before changing your new password.');
			redirect('profile');
		}
		
		else if(!empty($_POST['inputOldPassword']) && !empty($_POST['inputNewPassword'])){
			if(!$this->Profile_model->changePassword($_SESSION['userid'], $_POST['inputNewPassword'], $_POST['inputOldPassword']))
				$this->add_error('Password change unsuccessful', 'Please make sure you have typed your correct password');
			else
				$this->add_success('Password change success!');
			redirect('profile');
		}
		
		$previousUserInfo = $this->Profile_model->getUser($_SESSION['userid']);
		
		if(empty($_POST['inputUsername'])) $_POST['inputUsername'] = $previousUserInfo[$_SESSION['userid']]['login'];
		if(empty($_POST['inputFirstname'])) $_POST['inputFirstname'] = $previousUserInfo[$_SESSION['userid']]['firstname'];
		if(empty($_POST['inputMiddlename'])) $_POST['inputMiddlename'] = $previousUserInfo[$_SESSION['userid']]['middlename'];
		if(empty($_POST['inputLastname'])) $_POST['inputLastname'] = $previousUserInfo[$_SESSION['userid']]['lastname'];
		if(empty($_POST['inputEmail'])) $_POST['inputEmail'] = $previousUserInfo[$_SESSION['userid']]['school'];		
		if(empty($_POST['inputSchool'])) $_POST['inputSchool'] = $previousUserInfo[$_SESSION['userid']]['emailaddress'];		
		
		$this->Profile_model->changeDetails($_SESSION['userid'], $_POST['inputUsername'], $_POST['inputFirstname'], $_POST['inputMiddlename'], $_POST['inputLastname'], $_POST['inputEmail'], $_POST['inputSchool']);
		
		$this->add_success('Profile update successful');
		redirect('profile');
		// $this->render('test/tester');
	}
}
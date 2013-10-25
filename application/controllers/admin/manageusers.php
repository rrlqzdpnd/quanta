<?

class Manageusers extends Q_Controller {
	
	function __construct() {
        parent::__construct('Manageusers');
    }

	public function index(){
		$allUsers = $this->Manageusers_model->getUsers();
		$this->render('manageusers/index', compact('allUsers'));
		// echo '<pre>';
		// print_r($allUsers); die();
		// print_r($this->Test_model->get_data()); die();
		// ^ This is a very helpful debuggins statement. It prints the array itself!
		// ^ Note: If the printed array looks blargh, CTRL+U
		// $sailors = $this->Test_model->get_data();
		// $this->render('test/index', compact('sailors'));
	}
	
	public function makeadmin(){
		$userid = $_POST['inputUserid'];
		$this->Manageusers_model->makeAdmin($userid);
		
		$allUsers = $this->Manageusers_model->getUsers();
		$this->render('manageusers/index', compact('allUsers'));
		// die();
		// $this->render('test/tester');
	}

	public function makeuser(){
		$userid = $_POST['inputUserid'];
		$this->Manageusers_model->removeAdmin($userid);
		
		$allUsers = $this->Manageusers_model->getUsers();
		$this->render('manageusers/index', compact('allUsers'));
		// echo $_POST['inputUserid']; die();
		// echo 'make user'; die();
	}
}
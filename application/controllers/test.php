<?

class Test extends Q_Controller {
	
	function __construct() {
        parent::__construct('Test');
    }

	public function index(){
		// print_r($this->Test_model->get_data()); die();
		// ^ This is a very helpful debuggins statement. It prints the array itself!
		// ^ Note: If the printed array looks blargh, CTRL+U
		$sailors = $this->Test_model->get_data();
		$this->render('test/index', compact('sailors'));
	}
	
	public function tester(){
		$this->render('test/tester');
	}
}
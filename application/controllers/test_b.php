<?

class Test_b extends Q_Controller {

	function __construct() {
        parent::__construct('Test_b');
    }

	public function index(){
		$this->render('test_b/index');
	}
}
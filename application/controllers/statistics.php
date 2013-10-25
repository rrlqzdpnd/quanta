<?

class Statistics extends Q_Controller {

    function __construct() {
        parent::__construct('Statistics');
        // $this->load->model('Questions_model');
    }

	public function index(){
		if(!isset($_SESSION['userid']))
        {
            redirect('home');
        }
		$title = 'Statistics - Quanta';
		$scores = $this->Statistics_model->getTestScores($_SESSION['userid']);
        $this->add_warning('NOTE', 'Statistics will only show if  you have taken an exam in a subject more than ONCE.');
        $this->render('statistics/index', compact('scores','title'));
	}
	
	public function all(){
		if(!isset($_SESSION['userid']))
        {
            redirect('home');
        }
        // Check 1: If user is not an admin, GTFO of this module.
        if($_SESSION['usertype'] != 1)
            redirect();
        
		$title = 'Statistics - Quanta';
		$scores = $this->Statistics_model->getTestScores($_SESSION['userid']);
        $this->render('statistics/index', compact('scores','title'));
	}
}

<?

class Dashboard extends Q_Controller {

    function __construct() {
        parent::__construct('Dashboard');
        $this->load->model('Announcements_model');
    }

    public function index() {
        if(!isset($_SESSION['userid']))
        {
            redirect('home');
        }

        $data['title'] = "Dashboard - Quanta";
        $data['announcements'] = $this->Announcements_model->get_user();
        $this->render('user/index', $data);
    }
}


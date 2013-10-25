<?

class Announcements extends Q_Controller {

    function __construct() {
        parent::__construct('Announcements');
    }

    public function index() {
        show_404();
    }

    public function add() {
        //Check if post contains required data. If post does, add announcement.
        if(!empty($_POST['inputMessage']) && !empty($_SESSION['userid']) && !empty($_POST['inputTitle'])){
            $title = $this->input->post('inputTitle');
            $message = $this->input->post('inputMessage');

            //If add successful, send to announcement index. (Which displays all the announcements.)
            if($this->Announcements_model->add($title, $message, $_SESSION['userid']))
            {
                redirect('home');
            }
            else
            {
                $this->add_error('Oh snap! ', 'Something wrong happened. Please try adding your announcement again.');
                $this->render('dashboard/index', compact('message', 'title'));
            }
        }
        else{
            //Failed = redirect to add announcements
            redirect('home');
        }
    }
    public function set()
    {
        if(isset($_POST['annTag'])){
            $tags = explode(",", $this->input->post('annTag'));
            $active = ($tags[1] == 't') ? 'false' : 'true';
            //If add successful, send to announcement index. (Which displays all the announcements.)
            if($this->Announcements_model->set($tags[0], $active))
            {
                $state = ($tags[1] == 't') ? 'inactivated' : 'activated';
                $this->add_success('Woohoo! ', 'Successfully '.$state.' announcement.');
                redirect('home');
            }
            else
            {
                $this->add_error('Oh snap! ', 'Something wrong happened. Please try setting the post again.');
                $this->render('admin/dashboard/index', compact('message', 'title'));
            }
        }
        else{
            //Failed = redirect to add announcements
            redirect('home');
        }
    }
}

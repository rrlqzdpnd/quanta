<?

class ManageQuestions extends Q_Controller {

    function __construct() {
        parent::__construct('ManageQuestions');
    }

    public function index() {
        // Check 1: If user is not an admin, GTFO of this module.
        if($_SESSION['usertype'] != 1)
            redirect();

        $this->load->model('Practice_model');

        // Fetch all available subjects and their sets
        $data['title'] = "Manage Questions - Quanta";
        $data['subjects'] = $this->Practice_model->getSubjects();

        $this->render('admin/managequestions', $data);
    }

    public function addsubject() {
        if(!isset($_POST['subjectname'])) {
            show_404();
        }
        if(!empty($_POST['subjectname'])) {
            $subjectname = $this->input->post('subjectname');
            $description = $this->input->post('subjectdescription');

            $this->ManageQuestions_model->addSubject($subjectname, $description);
        }
        else {
            $this->add_error('Oh snap! ', 'Please fill in the subject name.');
        }
        redirect("admin/managequestions");
    }

    public function addset() {
        if(!isset($_POST['newSetName'])) {
            show_404();
        }
        if(!empty($_POST['newSetName']) && !empty($_POST['newQuestion'])
            && !empty($_POST['optionsRadios'])
            && !empty($_POST['choice1'])
            && !empty($_POST['choice2'])
            && !empty($_POST['choice3'])
            && !empty($_POST['choice4'])
            && !empty($_POST['subId'])
            && !empty($_POST['description']))
        {
            $newset = array();
            $newset['subId'] = $this->input->post('subId');
            $newset['setname'] = $this->input->post('newSetName');
            $newset['description'] = $this->input->post('description');
            $newset['initquestion'] = $this->input->post('newQuestion');
            $newset['choices'][0] = $this->input->post('choice1');
            $newset['choices'][1] = $this->input->post('choice2');
            $newset['choices'][2] = $this->input->post('choice3');
            $newset['choices'][3] = $this->input->post('choice4');
            $newset['initanswer'] = $this->input->post('optionsRadios');

            $res = $this->ManageQuestions_model->addSet($newset);

            switch($res) {
                case 'sets':
                    $this->add_error('Oh snap! ', 'The set info is malformed.'); break;
                case 'questions':
                    $this->add_error('Oh snap! ', 'The question info is malformed.'); break;
                case 'choices':
                    $this->add_error('Oh snap! ', 'One or more of the choices is/are malformed.'); break;
                case 'success':
                    $this->add_success('Hooray! ', 'Set is successfully added.'); break;
            }
        }
        else {
            $this->add_error('Oh snap! ', 'Please fill in all details.');
        }
        redirect("admin/managequestions");
    }

    public function commitchanges() {
        if(!isset($_POST['subid'])) {
            show_404();
        }
        if(!empty($_POST['subId']) && !empty($_POST['setId'])) {
            $subid = $this->input->post('subId');
            $setid = $this->input->post('setId');

            echo $subid." ".$setid; die();
        }
        else {
            $this->add_error('Oh snap! ', 'Refill form.');
        }
        redirect("admin/managequestions");
    }

    public function getSets() {
        if(!isset($_POST['subid'])) {
            show_404();
        }
        $this->load->model('Practice_model');
        $sets = $this->Practice_model->getSubjectSets($_POST['subid']);
        echo json_encode($sets);
    }

    public function getQuestions() {
        if(!isset($_POST['setid'])) {
            show_404();
        }
        $this->load->model('Practice_model');
        $questions = $this->Practice_model->getExam($_POST['setid']);
        echo json_encode($questions);
    }

    public function qTemplate() {
        if(!isset($_SESSION['userid'])) {
            show_404();
        }
        echo $this->load->view('admin/question.html');
    }

    public function getCorrectAnswer() {
        if(!isset($_POST['setid'])) {
            show_404();
        }
        $this->load->model('Practice_model');
        $answer = $this->Practice_model->getCorrectAnswer($_POST['setid'], $_POST['questionid']);

        echo $answer;
    }
}

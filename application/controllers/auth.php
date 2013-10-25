<?

class Auth extends Q_Controller {

    function __construct() {
        parent::__construct('Auth');
    }

    public function index() {
        //$this->add_success('Success Title', 'Success Body');
        //$this->add_warning('Error Title', 'Error Body');
        //$this->add_error('Warning Title', 'Warning Body');
        show_404();
    }

    public function login() {
        $data['title'] = "Log in - Quanta";

        //If the user has already logged in, redirect back to home.
        if(isset($_SESSION['userid']))
            redirect('home');

        //Check if post contains required data. If post does, login.
        if(!empty($_POST['inputEmail']) && !empty($_POST['inputPassword'])){
            $useremail = $this->input->post('inputEmail');
            $password = $this->input->post('inputPassword');

            //If login successful, store userid and username in session for access.
            if($userid = $this->Auth_model->validate($useremail, $password)){
                $_SESSION['username'] = $useremail;
                $_SESSION['userid'] = $userid;
                $_SESSION['name'] = $this->Auth_model->getname_byuserid($userid);
                $_SESSION['usertype'] = $this->Auth_model->getusertype_byuserid($userid);

                redirect('home');
            }
            else{
                //Failed = redirect to login
                $this->add_error('Oh snap! ', 'Check your username and password then try submitting again.');
                $this->render('auth/login', $data);
            }
        }
        else{
            //Failed = redirect to login
            $this->render('auth/login', $data);
        }
    }

    public function signup() {
        $data['title'] = "Sign up - Quanta";

        //If the user has already logged in, redirect back to home.
        if(isset($_SESSION['userid']))
            redirect('home');

        //Check if post contains required data. If post does, signup.
        if(!empty($_POST['inputUsername']) && !empty($_POST['inputEmail']) && !empty($_POST['inputPassword']) && !empty($_POST['inputFirstname']) && !empty($_POST['inputMiddlename']) && !empty($_POST['inputLastname']) && !empty($_POST['inputSchool'])){

            $username = $this->input->post('inputUsername');
            $email = $this->input->post('inputEmail');
            $password = $this->input->post('inputPassword');
            $firstname = $this->input->post('inputFirstname');
            $middlename = $this->input->post('inputMiddlename');
            $lastname = $this->input->post('inputLastname');
            $school = $this->input->post('inputSchool');

            //If signup successful.
            if($this->Auth_model->add_user($email, $username, $password, $firstname, $middlename, $lastname, $school)){
                $this->add_success('Well done! ', 'Log in now and check your profile.');
                redirect('auth/login');
            }
            else {
                $this->add_error('Oh snap! ', 'The username or e-mail you chose already exists.');
                redirect('auth/signup', $data);
            }
        }
        else{
			if(!empty($_POST))
				$this->add_error('Oh snap! ', 'Incomplete fields.');
            $this->render('auth/signup', $data);
        }
    }

    public function logout() {
        //Check if post contains required data. If post does, signup.
        session_destroy();
        session_start();
        session_destroy();

        //$this->render('layouts/home');
        redirect('home');
    }
}

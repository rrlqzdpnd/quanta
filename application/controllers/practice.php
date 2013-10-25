<?

class Practice extends Q_Controller {

    function __construct() {
        parent::__construct('Practice');
    }

    public function index() {
		$this->subjects();
    }

	public function subjects() {
        if(!isset($_SESSION['userid']))
        {
            redirect('home');
        }
		$title = 'Practice - Quanta';
		$subjects = $this->Practice_model->getSubjects();
        $this->render('practice/index', compact('subjects', 'title'));
	}

	public function exam() {
		if(isset($_SESSION['examtime'])){
			unset($_SESSION['examrandom']);
			unset($_SESSION['examchoicerand']);
			unset($_SESSION['examsetid']);
			unset($_SESSION['examtime']);
			$this->add_error('The exam is cancelled.', 'Please do not refresh the page during the exams.');
			redirect('practice/index');
			/*
			if(!empty($_POST['inputSetID'])){
				$this->add_error('You are already taking an exam!', 'You might have closed the exam page unintentionally.');
			}
			$randomizer = $_SESSION['examrandom'];
			$choice_rand = $_SESSION['examchoicerand'];
			$setid = $_SESSION['examsetid'];
			$time = $_SESSION['examtime'];
			$exams = $this->Practice_model->getExam($setid);
			$this->render('practice/exam', compact('exams', 'randomizer', 'choice_rand', 'setid', 'time'));
			*/
		}
		else if(!empty($_POST['inputSetID'])){
		
			$setid = $this->input->post('inputSetID');
			$exams = $this->Practice_model->getExam($setid);
			
			// echo 'got in here 2!<pre>';
			// print_r($_POST);
			// print_r($exams);
			// echo count($exams)-1;
			// die();
			
			//Randomizer for items
			$max = count($exams)-1;
			if($max != 0){
				$done = false;
				while(!$done){
					$randomizer = range(0, $max);
					shuffle($randomizer);
					$done = true;
					foreach($randomizer as $key => $val){
						if($key == $val){
							$done = false;
							break;
						}
					}
				}
			}
			else{
				$randomizer[0] = 0;
			}
			
			//Randomizer for choices
			$max = 3;
			$done = false;
			while(!$done){
				$choice_rand = range(0, $max);
				shuffle($choice_rand);
				$done = true;
				foreach($choice_rand as $key => $val){
					if($key == $val){
						$done = false;
						break;
					}
				}
			}

			$time = time();

			$_SESSION['examrandom'] = $randomizer;
			$_SESSION['examchoicerand'] = $choice_rand;
			$_SESSION['examsetid'] = $setid;
			$_SESSION['examtime'] = $time;

			$this->render('practice/exam', compact('exams', 'randomizer', 'choice_rand', 'setid', 'time'));
		}
		else redirect('home');
	}
	public function finish(){
		if(!empty($_POST['inputSetID'])){
			$setid = $_POST['inputSetID'];
			$correctAnswers = $this->Practice_model->getCorrectAnswers($setid);
			$exams = $this->Practice_model->getExam($setid);

			$correctAnswers = str_split($correctAnswers);
			$userAnswers = str_split($_POST['userAnswersString']);

			$correct = 0;
			$incorrect = 0;

			for($i=0; $i<count($correctAnswers); $i++){
				if($correctAnswers[$i] == $userAnswers[$i])
					$correct+=1;
				else
					$incorrect+=1;
			}
			$total = $correct+$incorrect;
			$percentCorrect = number_format($correct*100/$total, 2);
			$percentCorrect.='%';
			
			$this->Practice_model->saveHistory($_SESSION['userid'], (int)$correct*100/$total, $_POST['userAnswersString'], $setid, time(), $_SESSION['examtime']);
			
			$totaltime = time() - $_SESSION['examtime'];
			unset($_SESSION['examrandom']);
			unset($_SESSION['examchoicerand']);
			unset($_SESSION['examsetid']);
			unset($_SESSION['examtime']);
			$this->render('practice/results', compact('percentCorrect', 'userAnswers', 'correctAnswers', 'exams', 'totaltime'));
		}
		else{
			redirect('home');
		}		
	}
}

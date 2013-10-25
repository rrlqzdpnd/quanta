
<style>

.correct{
	border: 2px solid #2fcc71;
	/*background-color: #2fcc71;*/
	border-radius: 5px;
	padding: 5px;
	color: #2fcc71;
}

.incorrect{
	border: 2px solid #e84c3d;
	/*background-color: #e84c3d;*/
	border-radius: 5px;
	padding: 5px;
	color: #e84c3d;
}

.correct_msg{
	border-radius: 5px;
	display: inline;
	padding: 5px;
}

.nocolor{
	color: black;
	display: inline;
}

</style>

<div class="container">
    The results are in! You got <?=$percentCorrect?> correct.
    <br/>
	<br/>
    It took you <b><?=$totaltime?> seconds</b> to finish the exam.
	<br/>
	<br/>
	<? for($i=0; $i<count($exams); $i++):?>
		<div class="questions" id="question_<?echo $i?>">
			Question <?=$i+1?>:<br/><?=$exams[$i]['question']?>
			<div class="choices">
				<?for($j=0; $j<4; $j++):?>
					<?
						$correctString = '';
						$checked = '';
						$div_correct = '';
						
						//Check for user's answer
						if($userAnswers[$i] == $j){
							$checked = 'checked';
							//Check for correct answer
							if($correctAnswers[$i] == $userAnswers[$i]){
								$correctString = '<div class="correct_msg">Correct!</div>';
								$div_correct = 'class="correct"';
							}
							else{
								$correctString = '<div class="correct_msg">This was your answer.</div>';
								$div_correct = 'class="incorrect"';
							}
						}
						
						if($correctAnswers[$i] == $j){
							if($correctAnswers[$i] != $userAnswers[$i]){
								$correctString = '<div class="correct_msg">This is the correct answer.</div>';
								$div_correct = 'class="correct"';
							}
						}
							
						
					?>
				<div <?=$div_correct?>>
					<input type="radio" disabled <?=$checked?> name="question_<?echo $i?>" value="<?=$exams[$i]['choices'][$j]?>">
					<?='<div class="nocolor">'.$exams[$i]['choices'][$j].'</div>'?> <?=$correctString?><br/> 
				</div>
				<?endfor;?>
				<?if($userAnswers[$i] == 9):?>
					<div class="correct_msg">
						You have no answer.
					</div>
				<?endif;?>
			</div>
		</div>
		<hr class="featurette-divider">
	<? endfor;?>
</div>

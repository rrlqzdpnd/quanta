<? /*

To-do:
	[x] Randomize the questions
	[x] Randomize the choices
	[x] Display the randomization
	[x] Navigation between items
	[x] Display meter above
		Meter divided into number of questions.
		Green if answered, yellow if unsure, white if blank
	[x] Mark question as unsure
	[x] Randomized checker
	[x] Can refresh

*/ ?>
<script type="text/javascript">
	numItems = <?=count($exams)?>;
	jsChoiceRand = new Array();
	jsRandomizer = new Array();
	jsChoiceRand2 = new Array();

	$(document).ready(function(){
		//Preliminaries: building the meter and hiding the questions
		$('.submit_button').hide();
		percent = (100/$('.questionblock').length);
		$('.questionblock').css('width', percent+"%");
		$('.questions').hide();
		showQuestion(<?=$randomizer[0]?>);

		//Building the randomizer array
		<?for($i=0; $i<count($exams); $i++):?>
			jsRandomizer[<?=$i?>] = <?=$randomizer[$i]?>;
		<?endfor;?>
		<?for($i=0; $i<4; $i++):?>
			jsChoiceRand[<?=$i?>] = <?=$choice_rand[$i]?>;
		<?endfor;?>
	});

	function greenify(index){
		$('#questionblock_'+index).css('background-color', 'rgb(47, 204, 113)');
		$('#notSure_'+index).show();
		$('#sure_'+index).hide();

		itemsAnswered = 0;
		$('.questionblock').each(function(){
			if($(this).css('background-color') == 'rgb(47, 204, 113)' || $(this).css('background-color') == 'rgb(255, 216, 58)')
				itemsAnswered++;
		});

		if(itemsAnswered == numItems){
			$('.submit_button').show();
		}
	}

	function notSure(index){
		$('#questionblock_'+index).css('background-color', 'rgb(255, 216, 58)');
		$('#notSure_'+index).hide();
		$('#sure_'+index).show();
	}

	function showQuestion(index){
		$('.questions').hide();
		$('#question_'+index).show();
	}

	function gatherAnswers(){
		answerString = '';
		for(i=0; i<numItems; i++){
			rawIndex = $('input[name=question_'+i+']:checked' ).index()/2;  //I dunno why the index is doubled. .__.
																			// ._. ._. what is index
			if(rawIndex == -0.5){
				answerString += "9"; //means invalid option
			}
			else{
				offset = jsChoiceRand[rawIndex];
				answerString += offset.toString();
			}
		}
		$("#answerHidden").val(answerString);
	}

</script>

<style>

.exam_meter{
	width: 100%;
	height: 30px;
	border-radius:5px;
}

.questionblock{
	border: 2px solid white;
	background-color: #ccc;
	left: -1px;
	top: -1px;
	width: 100px;
	height: 30px;
	display: block;
	float: left;
	cursor: pointer;
}

.questionblock_leftmost{
	border-radius:5px 0px 0px 5px;
}

.questionblock_rightmost{
	border-radius:0px 5px 5px 0px;
}

.questions{
	padding: 5px;
}

.choices{
	padding: 5px;
}


</style>

<div class="container">
	<!-- The meter! O: -->
	<div class="exam_meter">
		<? $i = 0;?>
		<? while($i < count($exams)):?>
			<div class="questionblock
				<?	if($i == count($exams) - 1) echo 'questionblock_rightmost';
					else if ($i == 0) echo 'questionblock_leftmost';?>
				" id="questionblock_<?=$randomizer[$i]?>"
				onclick="showQuestion(<?=$randomizer[$i]?>);">

			</div>
			<? $i++;?>
		<? endwhile;?>
	</div>
	<span id="runner"></span>

	<br/>

	<!-- The questions -->
	<? foreach($randomizer as $key => $index):?>
		<div class="questions" id="question_<?echo $index?>">
			Question <?=$key+1?>:<br/><?=$exams[$index]['question']?>
			<div class="choices">
				<input type="radio" name="question_<?echo $index?>" value="<?=$exams[$index]['choices'][$choice_rand[0]]?>" onclick="greenify(<?=$index?>);">
					<?=$exams[$index]['choices'][$choice_rand[0]]?><br/>
				<input type="radio" name="question_<?echo $index?>" value="<?=$exams[$index]['choices'][$choice_rand[1]]?>" onclick="greenify(<?=$index?>);">
					<?=$exams[$index]['choices'][$choice_rand[1]]?><br/>
				<input type="radio" name="question_<?echo $index?>" value="<?=$exams[$index]['choices'][$choice_rand[2]]?>" onclick="greenify(<?=$index?>);">
					<?=$exams[$index]['choices'][$choice_rand[2]]?><br/>
				<input type="radio" name="question_<?echo $index?>" value="<?=$exams[$index]['choices'][$choice_rand[3]]?>" onclick="greenify(<?=$index?>);">
					<?=$exams[$index]['choices'][$choice_rand[3]]?><br/>
			</div>
			<?if($key!=0):?>
				<input type="submit" class="btn btn-primary" value="Prev" onclick="showQuestion(<?echo $randomizer[$key-1]?>)"/>
			<?endif;?>
			<input type="submit" class="btn btn-primary" class="notSure_button" style="display:none" id="notSure_<?=$index?>" value="Mark as Not Sure" onclick="notSure(<?echo $index?>)"/>
			<input type="submit" class="btn btn-primary" class="sure_button" style="display:none" id="sure_<?=$index?>" value="Mark as Sure" onclick="greenify(<?echo $index?>)"/>
			<?if($key<count($exams)-1):?>
				<input type="submit" class="btn btn-primary" value="Next" onclick="showQuestion(<?echo $randomizer[$key+1]?>)"/>
			<?endif;?>
		</div>
	<? endforeach;?>
	<form class="form-horizontal" action="<?=base_url()?>practice/finish" method="POST">
		<input type="hidden" name="inputSetID" value="<?=$setid?>"/>
		<input type="hidden" name="userAnswersString" id="answerHidden" value=""/>
		<input type="submit" class="btn btn-primary submit_button" value="Submit" onclick="gatherAnswers()"/>
	</form>

</div>

<script type="text/javascript">
	$('#runner').runner({
		countdown: true,
		startAt: <?=count($exams)*30000?> - (Date.now() - <?=$time?>*1000),
		stopAt: 0
	}).on('runnerFinish', function(eventObject, info) {
		gatherAnswers();
		$("form.form-horizontal").submit();
	});
	$('#runner').runner('start');

	/*


	<span id="timer"></span>
	var time = <?=$time?>;
	var timerID; //stores ID to clear Interval behavior of function later on
	function tick(){
		// $('.submit_button').show(); //shows the submit button for testing purposes
		timeElapsed = Math.floor(Date.now()/1000 - time);
		if(timeElapsed >= 30){
			$('#timer').html("Time's up.");
			window.clearInterval(timerID);
			gatherAnswers();
			$("form.form-horizontal").submit();
		}
		else{
			timeRemaining = 30 - timeElapsed;
			var output = Math.floor(timeRemaining/60)+ " minutes, " + (timeRemaining%60) + " seconds remaining";
			$('#timer').html(output);
		}
	}
	timerID = window.setInterval(tick,1000);
	*/
	//$('#runner').runner();
</script>

<? /*
<script type="text/javascript">
	function nextQuestion(index){
		prev=index-1;
		$('#question_'+prev).hide();
		$('#question_'+index).show();
	}
	function prevQuestion(index){
		prev=index-1;
		$('#question_'+index).hide();
		$('#question_'+prev).show();
	}
</script>




<?$question = 0;?>
<?$answerString = '';?>

<div class="container">
	<? foreach($exams as $item):?>
		<?if(isset($item['question'])):?>
			<div style="width: 100%; <? if($question!=0){echo 'display:none';}?>" id="question_<?echo $question?>">
				Question <? echo $question+1?>:<br/>
				<? echo $item['question']?>
				<form action="">
				<?foreach($item['choices'] as $choice):?>
					<input type="radio" name="<?echo $question?>" value="<?$choice?>"> <? echo $choice?><br/>
				<?endforeach;?>
				</form>
				<? $question+=1 ?>
				<?if($question!=0):?>
					<input type="submit" class="btn btn-primary btn-primary" value="Prev" onclick="prevQuestion(<?echo $question-1?>)"/>
				<?endif;?>
				<?if($question!=count($exams)):?>
					<input type="submit" class="btn btn-primary btn-primary" value="Next" onclick="nextQuestion(<?echo $question?>)"/>
				<?endif;?>
			</div>
		<?endif;?>
	<? endforeach;?>
    <?//<pre><?print_r($exams);</pre>?>
</div>
*/?>

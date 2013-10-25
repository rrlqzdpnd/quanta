aAA
<style>
#filler{
	height: 600px;
}
.historyChart{
	height: 400px;
	width: 600px;
	left: -1px;
	top: -1px;
}
</style>

<div class="container">
	<canvas id="historyChart" width="600" height="400">
	</canvas>
	<!--<? for($i = 0; $i != count($history); $i++):?>
		<?=$history[$i]['score']?> <?=$history[$i]['timefinished']?></br>
	<? endfor ?>-->
	<div id="filler"></div>
</div>

<script type="text/javascript">
	var data = {
		labels: [<? for($i = 0; $i != count($history); $i++):?>"<?=$history[$i]['timefinished']?>",<? endfor ?>],
		datasets: [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : [<? for($i = 0; $i != count($history); $i++):?><?=$history[$i]['score']?>,<? endfor ?>]
			}
		]
	}
	options = {
		scaleOverride : true,
		scaleSteps : 7,
		scaleStepWidth : 20,
		scaleStartValue : 0
	}
	var ctx = $("#historyChart").get(0).getContext("2d");
	var historyChart = new Chart(ctx).Line(data,options);
</script>

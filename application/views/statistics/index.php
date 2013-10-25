
<style>
canvas{
    position: relative;
    margin: -15px;
    left: 10%;
}
</style>

<div class="container">
    <? for($j = 0;$j != $scores['size']; $j++):?>
        <? if(!is_null($scores[$j]) && $scores[$j]['size'] > 1): ?>
            <div id="<?=$scores[$j]['subject']?>">
                <h2><?=$scores[$j]['subject']?></h2>
                <br />
                <canvas id="historyChart<?= $j ?>" height="400" width="800"></canvas>
            </div>
        <? endif; ?>
    <? endfor;?>
</div>

<script type="text/javascript" src="<?= base_url()?>assets/js/modernizr.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/jquery.inview.js"></script>

<script type="text/javascript">
    var options = {
        scaleOverride : true,
        scaleSteps : 5,
        scaleStepWidth : 20,
        scaleStartValue : 0,
        animation : Modernizr.canvas,
        bezierCurve : false,
    };

    <? for($j = 0;$j != $scores['size']; $j++):?>
    <? if(!is_null($scores[$j]) && $scores[$j]['size'] > 1): ?>
        var scores = [
            <?for($i = 0; $i != $scores[$j]['size']; $i++):?>
                <?= $scores[$j][$i]['score'] ?>,
            <?endfor;?>
        ];

        var slabels = [
            <?for($i = 0; $i != $scores[$j]['size']; $i++):?>
                "<?= $scores[$j][$i]['timefinished'] ?>",
            <?endfor;?>
        ];

        <? switch($scores[$j]['subject']) {
            case 'Math':
                $fillColor = "rgba(231, 76, 60, 0.5)";
                $strokeColor = "rgba(192, 57, 43,1.0)";
                $pointColor = $strokeColor;
                $pointStrokeColor = "#fff";
                break;
            case 'Science':
                $fillColor = "rgba(52, 152, 219,0.5)";
                $strokeColor = "rgba(41, 128, 185,1.0)";
                $pointColor = $strokeColor;
                $pointStrokeColor = "#fff";
                break;
            case 'English':
                $fillColor = "rgba(155, 89, 182,0.5)";
                $strokeColor = "rgba(142, 68, 173,1.0)";
                $pointColor = $strokeColor;
                $pointStrokeColor = "#fff";
                break;
            case 'History':
                $fillColor = "rgba(46, 204, 113,0.5)";
                $strokeColor = "rgba(39, 174, 96,1.0)";
                $pointColor = $strokeColor;
                $pointStrokeColor = "#fff";
                break;
            case 'Geography':
                $fillColor = "rgba(241, 196, 15,0.5)";
                $strokeColor = "rgba(243, 156, 18,1.0)";
                $pointColor = $strokeColor;
                $pointStrokeColor = "#fff";
                break;
            default:
                $fillColor = "rgba(149, 165, 166,0.5)";
                $strokeColor = "rgba(127, 140, 141,1.0)";
                $pointColor = $strokeColor;
                $pointStrokeColor = "#fff";
                break;
        } ?>

        var chartData<?=$j?> = {
            labels: slabels,
            datasets: [
                {
                    fillColor : "<?=$fillColor?>",
                    strokeColor : "<?=$strokeColor?>",
                    pointColor : "<?=$pointColor?>",
                    pointStrokeColor : "<?=$pointStrokeColor?>",
                    data : scores
                }
            ]
        }

        window['historyChart<?=$j?>'] = function () {
            var ctx = $("#historyChart<?=$j?>").get(0).getContext("2d");
            new Chart(ctx).Line(chartData<?=$j?>, options);
        };

        $("#historyChart<?=$j?>").on("inview", function() {
            var $this = $(this);
            $this.off("inview");
            setTimeout(window['historyChart<?=$j?>'], 300);
        });
    <? endif ?>
    <? endfor;?>
</script>

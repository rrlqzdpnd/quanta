<div class="container">
    <div class="page-header"><h1>Choose a subject</h1></div>
    <div class="panel-group" id="accordion">
        <? foreach($subjects as $id => $info):?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$id?>">
                    <h2><i class="acc <?=$info['icon']?>"></i><?=$info['name']?>
                    <? if(is_array($info['sets'])): ?>
                    <span class="badge pull-right"><?$n=count($info['sets']); echo $n.' '.(($n>1)?'sets':'set');?></span>
                    <? endif; ?>
                    </h2>
                </a>
                <p><?=$info['desc']?></p>
                </h4>
            </div>
            <div id="collapse<?=$id?>" class="panel-collapse collapse">
            <div class="panel-body">
                <? if (is_array($info['sets'])):?>
                <form class="form-inline" role="form" action="<?=base_url()?>practice/exam" method="POST">
                <? foreach($info['sets'] as $setid => $setname): ?>
                    <button type="submit" class="btn btn-primary btn-lg" id="inputSetID" name="inputSetID" value="<?=$setid?>">Take <?=lcfirst($setname)?></button>
                <? endforeach;?>
                </form>
                <? else:?>
                    No available sets for this category at the moment.
                <? endif;?>
            </div>
            </div>
        </div>
        <? endforeach;?>
    </div>
</div>

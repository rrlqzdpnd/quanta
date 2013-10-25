<? if(isset($warning_messages)): ?>
	<? foreach($warning_messages as $title => $messages): ?>
    <div class="container message">
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong><?= $title ?></strong>
		<? if(count($messages) > 1): ?>
			<ul>
			<? foreach($messages as $message): ?>
				<li><?= $message ?></li>
			<? endforeach; ?>
			</ul>
		<? else: ?>
			<span><?= $messages[0] ?></span>
		<? endif; ?>
	   </div>
    </div>
	<? endforeach; ?>
<? endif; ?>

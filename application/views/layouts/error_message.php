<? if(isset($error_messages)): ?>
    <div class="container message">
	<? foreach($error_messages as $title => $messages): ?>
    <div class="alert alert-danger">
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
	<? endforeach; ?>
    </div>
<? endif; ?>

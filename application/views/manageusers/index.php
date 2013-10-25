<style>
	td{
		padding: 5px;
		padding-top: 10px;
	}
	th{
		border-bottom: 1px solid black;
		padding-bottom: 5px;
	}

</style>
<div class="container">
	<br/>
	<legend>User information</legend>
	<br/>
	<table width="100%">
		<tr>
			<th>Username</th>
			<th>Full Name</th>
			<th>User Type</th>
			<th>Action</th>
		</tr>
		<? foreach($allUsers as $user): ?>
		<tr>
			<td><?=$user['login']?></td>
			<td><?=$user['fullname']?></td>
			<td><?=$user['usertype']?></td>
			<td>
				<? if($user['usertype'] == 'Normal User'):?>
				<form action="<?=base_url()?>admin/manageusers/makeadmin" method="POST">
					<input type="hidden" name="inputUserid" value="<?=$user['userid']?>"/>
					<input type="submit" value="Make Admin" class="btn btn-primary" href="#"/>
				</form>
				<? else:?>
				<form action="<?=base_url()?>admin/manageusers/makeuser" method="POST">
					<input type="hidden" name="inputUserid" value="<?=$user['userid']?>"/>
					<input type="submit" value="Make User" class="btn btn-primary" href="#"/>
				</form>
				<? endif;?>
			</td>
		</tr>
		<? endforeach; ?>
	</table>
	
</div>

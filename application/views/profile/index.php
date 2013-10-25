<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $('.icon-eye-open').click(function() {
        $(this).toggleClass("icon-eye-open icon-eye-close");
        ($("#inputPassword").attr("type") == "text") ?
            $("#inputPassword")[0].setAttribute("type", "password") :
            $("#inputPassword")[0].setAttribute("type", "text");
    });
});
</script>

<div class="container form-login">
	
	<?/*
		Supports changing the following fields:
			first name
			middle name
			last name
			email
			school
			password (requires old password)
	*/?>
	<legend>User account information</legend>
    <form class="form-horizontal" action="<?=base_url()?>profile/edit" method="POST">
        <div class="form-group">
            <div class="col-lg-4">
                <input type="text" class="form-control" id="inputFirstname" name="inputFirstname" placeholder="<?=$userinfo[$_SESSION['userid']]['firstname']?>">
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="inputMiddlename" name="inputMiddlename" placeholder="<?=$userinfo[$_SESSION['userid']]['middlename']?>">
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="inputLastname" name="inputLastname" placeholder="<?=$userinfo[$_SESSION['userid']]['lastname']?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputSchool" name="inputSchool" placeholder="<?=$userinfo[$_SESSION['userid']]['school']?>" data-toggle="tooltip" title="first tooltip">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="<?=$userinfo[$_SESSION['userid']]['emailaddress']?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="<?=$userinfo[$_SESSION['userid']]['login']?>">
            </div>
        </div>
        <div class="form-group input-append">
            <div class="col-lg-12">
                <span class="add-on"><i class="icon-eye-open"></i></span>
                <input type="password" class="form-control" id="inputOldPassword" name="inputOldPassword" placeholder="Old Password">
            </div>
        </div>
		 <div class="form-group input-append">
            <div class="col-lg-12">
                <span class="add-on"><i class="icon-eye-open"></i></span>
                <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword" placeholder="New Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">Change Details</button>
            </div>
        </div>
    </form>	
</div>
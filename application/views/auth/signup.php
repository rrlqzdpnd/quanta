<div class="container form-login">
    <form class="form-horizontal" action="<?=base_url()?>auth/signup" method="POST">
        <legend>Create a new account <em>or</em> <a href="<?= base_url()?>auth/login">log in</a>
		<div style="font-size: 0.7em">All fields are required.</div>
		</legend>
        <div class="form-group">
            <div class="col-lg-4">
                <input type="text" class="form-control" id="inputFirstname" name="inputFirstname" placeholder="First Name">
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="inputMiddlename" name="inputMiddlename" placeholder="Middle Name">
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="inputLastname" name="inputLastname" placeholder="Last Name">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputSchool" name="inputSchool" placeholder="School" data-toggle="tooltip" title="first tooltip">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email Address">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="Username">
            </div>
        </div>
        <div class="form-group input-append">
            <div class="col-lg-12">
                <span class="add-on"><i class="icon-eye-open"></i></span>
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">Sign up</button>
            </div>
        </div>
    </form>
</div>

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

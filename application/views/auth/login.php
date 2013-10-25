<div class="container form-login">
    <form class="form-horizontal" action="<?=base_url()?>auth/login" method="POST">
        <legend>Log in to Quanta <em>or</em> <a href="<?= base_url()?>auth/signup">create a new account</a></legend>
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Username or Email">
            </div>
        </div>
        <div class="form-group input-append">
            <div class="col-lg-12">
                <span class="add-on"><i class="icon-eye-open"></i></span>
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <a href="#">Forgot password?</a>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">Log in</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $('.icon-eye-open').click(function() {
        $(this).toggleClass("icon-eye-close");
        ($("#inputPassword").attr("type") == "text") ?
            $("#inputPassword")[0].setAttribute("type", "password") :
            $("#inputPassword")[0].setAttribute("type", "text");
    });
});
</script>

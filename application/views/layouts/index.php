<!DOCTYPE html>
<html lang="en">
<head>
<? //Declare php variables in here
    $tags = array('auth/signup', 'auth/login');
    //$usertype = rtrim($this->router->fetch_directory(), "/");
    $curPage = $this->router->fetch_class()."/".$this->router->fetch_method();
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Quanta — Practice college entrance tests and get instant results!" />
    <meta name="description" content="Practice UPCAT, ACET, DLSUCET, USTET, etc., and get instant results!">
    <meta property="og:description" content="Practice UPCAT, ACET, DLSUCET, USTET, etc., and get instant results!" />
    <meta property="og:image" content="<?= base_url()?>assets/img/quanta-logo.png" />

    <title><?= (isset($data['title'])) ? $data['title'] : null ?></title>

    <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url()?>assets/css/font-awesome.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url()?>assets/css/layouts.css" type="text/css" />

    <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if IE 7]>
        <link href="<?= base_url()?>assets/css/font-awesome-ie7.min.css" rel="stylesheet">
    <![endif]-->

    <script type="text/javascript" src="<?= base_url()?>assets/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>assets/js/jquery.runner.js" ></script>
    <script type="text/javascript" src="<?= base_url()?>assets/js/Chart.js" ></script>
    <script type="text/javascript" src="<?= base_url()?>assets/js/javascripts.js"></script>

</head>
<body data-spy="scroll" data-target=".sidebar" data-baseurl="<?=base_url()?>">
    <div class="navbar navbar-static-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url()?>"><img src="<?= base_url()?>assets/img/quanta-logo.png" width="50" alt="Quanta"/></a>
            <ul class="nav navbar-nav">
                <? if(isset($_SESSION['userid'])): ?>
                <? if($this->router->fetch_class() == "dashboard"): ?>
                <li class="nav-button"><a class="btn btn-primary" href="<?= base_url()?>practice">Practice</a></li>
                <? else: ?>
                <li class="nav-button"><a class="btn btn-primary" href="<?= base_url()?>">Dashboard</a></li>
                <? endif; ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['name']?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dd-item"><a href="<?= base_url()?>"><i class="icon-dashboard"></i>&nbsp; Dashboard</a></li>
                        <li class="dd-item"><a href="<?= base_url()?>profile"><i class="icon-user"></i>&nbsp; Profile</a></li>
                        <? if($_SESSION['usertype'] == 2): ?>
                        <li class="dd-item"><a href="<?= base_url()?>statistics"><i class="icon-bar-chart"></i>&nbsp; Statistics</a></li>
                        <? //<li class="dd-item"><a href="#"><i class="icon-compass"></i>&nbsp; Resources</a></li>?>
                        <? else: ?>
                        <li class="dd-item"><a href="<?= base_url()?>admin/manageusers"><i class="icon-group"></i>&nbsp; Manage users</a></li>
                        <li class="dd-item"><a href="<?= base_url()?>admin/managequestions"><i class="icon-question-sign"></i>&nbsp; Manage questions</a></li>
                        <? endif; ?>
                        <li class="divider"></li>
                        <li class="dd-item"><a href="<?= base_url()?>auth/logout"><i class="icon-signout"></i>&nbsp; Log out</a></li>
                    </ul>
                </li>
                <? elseif(!in_array($curPage, $tags)): ?>
                <li><a href="<?= base_url()?>auth/login">Log In</a></li>
                <li class="nav-button"><a class="btn btn-primary" href="<?= base_url()?>auth/signup">Sign up</a></li>
                <? endif; ?>
            </ul>
            <hr class="featurette-divider">
        </div>
    </div>
	<? $this->load->all_messages(); ?>
    <? $this->load->view($view, $data); //Load view ?>
    <? if(!in_array($curPage, $tags)): ?>
    <div class="footer">
        <div class="container">
            <p>&copy; 2013. <a href="mailto:kiefer.yap@gmail.com">Contact a human.</a></p>
        </div>
    </div>
    <? endif; ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en-us" id="extr-page">
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
    <title> VETRINA MIA - Designer System</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="<?=base_url("assets/backend/css/bootstrap.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/backend/css/font-awesome.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/backend/css/smartadmin-production.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/backend/css/smartadmin-skins.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/backend/css/signin.css")?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/btn-style.css") ?>">    
    <link rel="shortcut icon" href="<?=base_url("assets/backend/img/favicon/favicon.ico")?>" type="image/x-icon">
    <link rel="icon" href="<?=base_url("assets/backend/img/favicon/favicon.ico")?>" type="image/x-icon">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
</head>
<body>
	<div class="htmleaf-container">
		<header class="htmleaf-header">	
		</header>
		
	</div>
	

</body></html>
<body class="animated fadeInDown">
<header id="header">
    <div id="logo-group">
        <span id="logo" style="margin: 5px;"><img src="<?= check_file_path('assets/backend/img/logo.png') ?>" alt="VETRINA MIA - Designer System" style="width: auto; height: 60px;"></span>
    </div>
</header>
<div id="main" role="main">
    <!-- MAIN CONTENT -->
    <div class="signin">
        <div class="signin-head" style="margin-left: 14%;"><img src="<?= check_file_path('assets/backend/img/logo.png') ?>" alt="" style="width: 150px; height: auto;"></div>
        <div class="form-signin" style="margin-top:-10px">
            <?php echo form_open("backend/personal/panel/logindo", array("class" => "smart-form client-form", "id" => "login-form")) ?>
            <label class="input"><input type="text" class="form-control" name="username" placeholder="Account" required="" autofocus="" style="height:45px">
            <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Account</b></label>

            <label class="input"><input type="password" class="form-control" name="password" placeholder="Password" required="" style="height:45px">
            <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Password</b></label>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnSubmit">Login</button>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=base_url("assets/backend/js/plugin/pace/pace.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/backend/js/libs/jquery-2.1.1.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/backend/js/libs/jquery-ui-1.10.3.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/backend/js/bootstrap/bootstrap.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/backend/js/plugin/jquery-validate/jquery.validate.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/backend/js/plugin/masked-input/jquery.maskedinput.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/backend/js/app.config.js")?>"></script>
<!--[if IE 8]>
<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
<![endif]-->
<script type="text/javascript" src="<?=base_url("assets/backend/js/app.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/backend/js/speech/voicecommand.min.js")?>"></script>

<script type="text/javascript">
    runAllForms();
    $(function () {
        // Validation
        $("#login-form").validate({
            // Rules for form validation
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                }
            },
            // Messages for form validation
            messages: {
                username: {
                    required: '請輸入帳號'
                },
                password: {
                    required: '請輸入密碼'
                }
            },
            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });
    });
</script>
</body>
</html>

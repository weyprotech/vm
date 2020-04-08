<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
    <title> <?= !empty($title) ? $title : 'VETRINA MIA - Management system' ?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/bootstrap.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/font-awesome.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/smartadmin-production-plugins.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/smartadmin-production.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/smartadmin-skins.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/sweetalert2.min.css") ?>">
    <link rel="shortcut icon" href="<?= base_url("assets/backend/img/favicon/favicon.ico") ?>" type="image/x-icon">
    <link rel="icon" href="<?= base_url("assets/backend/img/favicon/favicon.ico") ?>" type="image/x-icon">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/btn-style.css") ?>">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script src="<?= base_url("assets/backend/js/libs/jquery-2.1.1.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/sweetalert2.all.min.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/promise.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/jquery-validate/jquery.validate.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/bootstrapvalidator/bootstrapValidator.min.js") ?>"></script>
    <style>
        #preview img{
            width:200px;
        }
    </style>
</head>
<body class="">
<header id="header">
    <div id="logo-group">
        <span id="logo" style="margin: 5px;"><img src="<?= check_file_path('assets/backend/img/logo.png') ?>" alt="VETRINA MIA - Management system" style="width: auto; height: 40px;"></span>
    </div>
    <div class="pull-right">
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <div id="logout" class="btn-header transparent pull-right">
            <?php if(!$this->session->userdata('designer_logged_in')){ ?>
                <span> <a href="<?= site_url("backend/panel/logout") ?>" title="Logout" data-action="userLogout" data-logout-msg="Are you sure?"><i class="fa fa-sign-out"></i></a> </span>
            <?php }else{ ?>
                <span> <a href="<?= site_url("backend/personal/panel/logout") ?>" title="Logout" data-action="userLogout" data-logout-msg="Are you sure?"><i class="fa fa-sign-out"></i></a> </span>             
            <?php } ?>
        </div>
        <div id="fullscreen" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
        </div>
        <!-- <ul class="header-dropdown-list">
            <li class="">
                <ul id="locale-menu" class="dropdown-menu pull-right">
                    <?php $current_lang = false; ?>
                    <?php if ($this->langList) { ?>
                        <?php foreach ($this->langList as $lrow) { ?>
                            <?php if ($lrow->langId == $this->langId) $current_lang = $lrow; ?>
                            <li class="<?= $lrow->langId == $this->langId ? 'active' : '' ?>" data-locale="<?= $lrow->locale ?>">
                                <a href="javascript:void(0);"><?= $lrow->name ?></a>
                            </li>
                            <?php 
                        }
                    } ?>
                </ul>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span><?= $current_lang ? $current_lang->name : "" ?></span> <i class="fa fa-angle-down"></i>
                </a>
            </li>
        </ul> -->
    </div>
</header>

<aside id="left-panel">
    <div class="login-info">
        <span>
            <?php $adminId = $this->session->userdata('adminId'); ?>
            <a href="<?= $adminId ? site_url('backend/admin/edit/' . $adminId) : 'javascript:void(0);' ?>" id="show-shortcut">
                <img src="<?= base_url("assets/backend/img/avatars/male.png") ?>" alt="me" class="online">
                <?php if(!$this->session->userdata('designer_logged_in')){ ?>
                    <span>HI，<?= $this->session->userdata('adminName') ?></span>
                <?php }else{ ?>
                    <span>HI，<?= $this->session->userdata('designerName') ?></span>                    
                <?php } ?>

            </a>
        </span>
    </div>
    <nav>
        <ul>
            <?php if(!$this->session->userdata('designer_logged_in')){ ?>
                <?php if (isset($menuList[0])) { ?>
                    <?php foreach ($menuList[0]['sub'] as $sub) { ?>
                        <?= get_menu_item($menuList[$sub]) ?>
                        <?php 
                    }
                } ?>
            <?php }else{ ?>
                <li class="active">
                    <a href="<?= site_url('backend/personal/blog') ?>" title="Blog">
                        <i class="fa fa-lg fa-fw fa-pencil-square-o"></i>
                        <span class="menu-item-parent">Blog</span>
                    </a>       
                </li>
            <?php } ?>
        </ul>
    </nav>
    <span class="minifyme" data-action="minifyMenu" style=""> <i class="fa fa-arrow-circle-left hit"></i> </span>
</aside>

<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <?php ksort($breadcrumbs); ?>
            <?php foreach ($breadcrumbs as $brow) { ?>
                <?= '<li><a href="' . $brow['url'] . '">' . $brow['title'] . '</a></li>' ?>
                <?php 
            } ?>
            <?= '<li>' . $page_title . '</li>' ?>
        </ol>
    </div>

    <div id="content">
        <?= $content ?>
    </div>
</div>

<div class="page-footer">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <span class="txt-color-white">Copyright (C) 2020 <span class="txt-color-red">VETRINA MIA</span> All Rights Reserved</span>
        </div>
    </div>
</div>

<script src="<?= base_url("assets/backend/js/plugin/pace/pace.min.js") ?>" data-pace-options='{ "restartOnRequestAfter": true }'></script>
<script src="<?= base_url("assets/backend/js/libs/jquery-ui-1.10.3.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/app.config.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/bootstrap/bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/notification/SmartNotification.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/smartwidgets/jarvis.widget.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/sparkline/jquery.sparkline.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/jquery-validate/jquery.validate.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/masked-input/jquery.maskedinput.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/select2/select2.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/sweetalert2.all.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/bootstrap-slider/bootstrap-slider.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/msie-fix/jquery.mb.browser.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/fastclick/fastclick.min.js") ?>"></script>
<!--[if IE 8]>
<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
<![endif]-->
<script src="<?= base_url("assets/backend/js/app.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/speech/voicecommand.min.js") ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        pageSetUp();

        $('#locale-menu li').click(function () {
            var locale = $(this).data('locale');
            $.ajax({
                url: "<?= site_url('backend/ajax/switchLang') ?>",
                type: "post",
                data: {locale: locale},
                dataType: "json",
                success: function (data) {
                    if (data['status']) {
                        location.reload();
                    }
                }
            })
        });
    });
</script>
</body>
</html>
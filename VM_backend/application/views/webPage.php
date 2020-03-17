<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php krsort($pageMeta['title']); ?>
<title><?= implode(" - ", $pageMeta['title']) ?></title>
<meta name="description" content="<?= $pageMeta['description'] ?>">
<meta name="author" content="service@weypro.com"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>">
<link rel="stylesheet" href="<?= base_url('assets/styles/main.css') ?>">
<?php
if ($this->langFile != 'cn') { ?>
<!-- Schema.org markup for Google+ --> 
<meta itemprop="name" content="<?= implode(" - ", $pageMeta['title']) ?>"> 
<meta itemprop="description" content="<?= $pageMeta['description'] ?>"> 
<meta itemprop="image" content="<?= $pageMeta['image'] ?>">
<!-- Open Graph data --> 
<meta property="og:title" content="<?= implode(" - ", $pageMeta['title']) ?>"/>
<meta property="og:description" content="<?= $pageMeta['description'] ?>"/>
<meta property="og:image" content="<?= $pageMeta['image'] ?>"/>
<meta property="og:url" content="<?= $pageMeta['url'] ?>"/>
<?
} ?>
</head>
<body><!--[if lt IE 9]>
<div class="old_browser">
    <div class="old_browser_inner">
        <div class="oops">OOPS!</div>
        <h1>您的瀏覽器版本太舊了！</h1>
        <p>請更新至 Internet Explorer 9 以上版本或選用更現代化的瀏覽器，<br><br>使用老舊版本的瀏覽器瀏覽本網站將可能有無法預測的錯誤，請儘快更新。<br><br>建議您使用<a href="http://www.google.com/chrome/" target="_blank"> Google Chrome 瀏覽器</a><br><br></p>
        <p>Copyright 2016 / All rights reserved.</p>
    </div>
</div><![endif]-->
<div>
    <?= $header ?>
    <?= $main ?>
    <?= $footer ?>
</div>
<?= $this->load->view('shared/_script', '', true) ?>
<script src="<?= base_url("assets/scripts/custom.js") ?>"></script>
<script>
    website.Init('<?= website_url() ?>', '<?= base_url() ?>');
    <?= $script ?>
</script>
</body>
</html>
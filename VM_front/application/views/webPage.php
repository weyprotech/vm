<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php krsort($pageMeta['title']); ?>
<title><?= implode(" - ", $pageMeta['title']) ?></title>
<meta name="KeyWords" content="">
<meta name="description" content="<?= $pageMeta['description'] ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css">
<link rel="stylesheet" href="<?= base_url('assets/styles/main.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/styles/lity.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/styles/sweetalert2.min.css") ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/styles/datepicker.css") ?>">
<script src="<?= base_url('assets/scripts/jquery.js') ?>"></script>
<script src="<?= base_url('assets/scripts/lity.js') ?>"></script>


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
<?php } ?>
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
    <?= $loading ?>
    <?= $header_top ?>
    <div id="wrapper">
        <?= $header ?>
        <?= $main ?>
    </div>    
    <?= $footer ?>
    <?= $sidebar ?>
    <!-- Cookie宣告-->
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js"></script>
    <script>
      //偵測要宣告的語言
      if(window.location.href.indexOf('tw') > -1){
        pageLang = 'tw';
      } else {
        pageLang = 'en';
      }
      switch(pageLang) {
        case 'tw':
          cookiePopup = '為提供使用者最佳體驗，本公司網站使用瀏覽器Cookie。使用本網站即表示您同意cookie的放置。有關更多使用Cookie詳情，請參閱我們的隱私政策。';
          break;
        default:
          cookiePopup = 'We use cookies to provide the best possible user experience for visiting our web. By using this website you agree to the placement of cookies. For more detail about using cookies, visit privacy policy.';
      }
      window.addEventListener('load', function(){
        window.cookieconsent.initialise({
          'palette': {
            'popup': {
              'background': '#B4A189',
              'text': '#ffffff'
            },
            'button': {
              'background': '#D5C9B0'
            }
          },
          'theme': 'classic',
          'type': 'opt-out',
          'content': {
            'message': cookiePopup,
            'href': 'javascript:;'
          }
        });
      });
    </script>
    <!-- Cookie宣告結束-->
    <script src="<?= base_url("assets/scripts/vendor.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/plugins.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/main.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/plugins/leaflet.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/storeMap.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/custom.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/sweetalert2.all.min.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/datepicker.js") ?>"></script>
    <script>
        website.Init('<?= site_url() ?>', '<?= base_url() ?>','<?= $this->langFile ?>');
    </script>
    <?= $this->load->view('shared/_script', '', true) ?>
    <?= $script ?>
</body>
</html>
<div class="main">
    <div class="page_banner">
    <div class="pic" style="background-image: url(http://vm-backend.4webdemo.com/<?= $img ?>)"><img class="size" src="<?= base_url('assets/images/size_50x13.png') ?>"></div>
    </div>
    <div class="designer_blog detail_wrapper page_block">
    <div class="block_inner">
        <div class="detail_article">
        <h1 class="block_title"><?= $title ?></h1>
        <div class="author_share">
            <div class="designer_info">
            <div class="profile_picture">
                <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                <div class="pic" style="background-image: url(http://vm-backend.4webdemo.com/<?= $designer->designiconImg ?>"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
            </div>
            <div class="text">
                <div class="designer_name">
                <?php if($designer->grade == 1){ ?>
                    <!--↓ 知名設計才會有鑽石icon ↓--><i class="icon_diamond_b"></i>
                    <!--↑ 知名設計才會有鑽石icon ↑-->
                <?php } ?>
                <span><?= $name ?></span>
                </div>
                <div class="country"><img class="flag" src="<?= base_url('assets/images/flag/'.$country.'.png') ?>"><span><?= get_all_country($country) ?></span></div>
            </div>
            </div>
            <div class="share_links">Share:<a class="facebook" href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a><a class="pinterest" href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a><a class="twitter" href="javascript:;" target="_blank"><i class="icon_share_twitter"></i></a><a class="weibo" href="javascript:;" target="_blank"><i class="icon_share_weibo"></i></a></div>
        </div>
        <div class="article_content">
            <?= $content ?>
        </div>
        </div>
    </div>
    </div>
</div>
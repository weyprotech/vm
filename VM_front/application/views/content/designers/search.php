<main id="main">
    <div class="filter_search_bar">
        <div class="bar_inner">
            <div class="filter_buttons">
                <a href="<?= website_url('designers') ?>">All</a>
                <a class="active">A-Z</a>
            </div>
            <form method="get">
                <div class="search_form">
                    <input type="search" name="search" placeholder="Designer name">
                    <button type="submit"><i class="icon_search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!--↓ 篩選選 A-Z 時才顯示 ↓-->
    <div class="filter_a2z">
        <div class="a2z_inner">
            <?php $list = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); 
            foreach($list as $listKey => $listValue){?>
                <a <?= $listValue == $alphabet ? 'class="current"' : '' ?> href="<?= website_url('designers/search').'?alphabet='.$listValue ?>"><?= $listValue ?></a>
            <?php } ?>
        </div>
    </div>
    <!--↑ 篩選選 A-Z 時才顯示 ↑-->
    <div class="search_block page_block">
        <div class="block_inner">
            <h2 class="block_title">Search Results for ”<?= $search.$alphabet ?>”</h2>
            <div class="block_main">
                <div class="search_title">Designers</div>
                <div class="search_main">
                    <div class="topping_list designer_topping_list">
                        <?php if($designerList){
                            foreach($designerList as $designerKey => $designerValue){ ?>
                                <div class="item">
                                    <a class="item_content" href="<?= website_url('designers/home').'?designerId='.$designerValue->designerId ?>">
                                        <div class="thumb">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url($designerValue->designImg) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                            </div>
                                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </div>
                                        <div class="intro">
                                            <div class="intro_inner">
                                                <div class="profile_picture" href="<?= website_url('designers/home').'?designerId='.$designerValue->designerId ?>">
                                                    <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                    <div class="pic" style="background-image: url(<?= backend_url($designerValue->designiconImg) ?>)">
                                                        <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                    </div>
                                                    <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                                </div>
                                                <h3 class="designer_name">
                                                <!--↓ 知名設計才會有鑽石icon ↓--><i class="icon_diamond_s"></i>
                                                <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('assets/images/flag/'.$designerValue->country.'.png') ?>"><span><?= $designerValue->name ?></span>
                                                </h3>
                                                <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($designerValue->description, ENT_QUOTES, "UTF-8"))),"0","200","UTF-8") ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
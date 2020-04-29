<main id="main">
    <div class="feature_designers page_block">
        <div class="block_inner wide">
            <h2 class="block_title">Feature Designers</h2>
            <div class="block_main">
                <div class="designers_slider">
                    <?php if($designerList){
                        for($i = 0;$i < 3;$i++){ 
                            if(isset($designerList[$i])){ ?>        
                                <div class="slide">
                                    <div class="designer_card">
                                        <a class="btn_favorite" data-designerId="<?= $i ?>" href="javascript:;">
                                            <i class="icon_favorite_heart"></i>
                                        </a>
                                        <a class="card_content" href="<?= website_url('designers/home').'?designerId='.$designerList[$i]->designerId ?>">
                                            <div class="thumb">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                <div class="pic" style="background-image: url(<?= backend_url($designerList[$i]->designImg) ?>);">
                                                    <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                </div>
                                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                            </div>
                                            <div class="intro">
                                                <div class="profile_picture">
                                                    <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                    <div class="pic" style="background-image: url(<?= backend_url($designerList[$i]->designiconImg) ?>)">
                                                        <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                    </div>
                                                    <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                                </div>
                                                <h3 class="designer_name">
                                                    <!--↓ 知名設計才會有鑽石icon ↓--><?= $designerList[$i]->grade == 1 ? '<i class="icon_diamond_b"></i>' : '' ?>
                                                    <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('assets/images/flag/'.$designerList[$i]->country.'.png') ?>"><span><?= $designerList[$i]->name ?></span>
                                                </h3>
                                                <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($designerList[$i]->description, ENT_QUOTES, "UTF-8"))),"0","200","UTF-8") ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php } 
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="popular_designers page_block">
        <div class="block_inner wide">
        <h2 class="block_title">Our Popular Designers</h2>
            <div class="block_main">
                <div class="popular_block_wrapper">
                    <?php if($designerList){
                        for($i=3;$i<=7;$i++){ 
                            if(isset($designerList[$i])){?>
                                <div class="popular_block">
                                    <div class="popular_block_inner">
                                        <div class="popular_picture">
                                            <a class="thumb" href="<?= website_url('designers/home').'?designerId='.$designerList[$i]->designerId ?>">
                                                <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                <div class="pic" style="background-image: url(<?= backend_url($designerList[$i]->designImg) ?>);">
                                                    <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                </div>
                                                <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                            </a>
                                            <a class="btn common" href="<?= website_url('designers/home').'?designerId='.$designerList[$i]->designerId ?>">Read more</a>
                                        </div>
                                        <div class="popular_content">
                                            <a class="designer_info" href="<?= website_url('designers/home').'?designerId='.$designerList[$i]->designerId ?>">
                                                <div class="profile_picture">
                                                    <div class="pic" style="background-image: url(<?= backend_url($designerList[$i]->designiconImg) ?>)">
                                                        <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                    </div>
                                                </div>
                                                <div class="designer_name">
                                                    <!--↓ 知名設計才會有鑽石icon ↓--><?= $designerList[$i]->grade == 1 ? '<i class="icon_diamond_b"></i>' : '' ?>
                                                    <!--↑ 知名設計才會有鑽石icon ↑--><span><?= $designerList[$i]->name ?></span>
                                                </div>
                                            </a>
                                            <div class="text"><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($designerList[$i]->description, ENT_QUOTES, "UTF-8"))),"0","200","UTF-8") ?></div>
                                            <?php if(!empty($designerList[$i]->runway[0]->imgList[0])){ ?>
                                                <a class="thumb <?= !empty($designerList[$i]->runway[0]->imgList[0]->youtube) ? 'is_video' : '' ?> popup" href="<?= website_url('designers/popup/event/'.$designerList[$i]->runway[0]->runwayId) ?>">
                                                    <div class="pic" style="background-image: url(<?= backend_url($designerList[$i]->runway[0]->imgList[0]->runwayImg) ?>);">
                                                        <img class="size" src="<?= base_url('assets/images/size_16x9.png') ?>">
                                                    </div>
                                                </a>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    } ?>
                </div><a class="btn common more" id="more_popular_designers" data-start=7>More designers</a>
            </div>
        </div>
    </div>
</main>
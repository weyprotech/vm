<main id="main">
    <div class="topping_block designer_profile_topping">
        <div class="block_inner">
            <div class="topping_header">
                <div class="thumb">
                    <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(<?= backend_url($row->designImg) ?>);">
                        <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                    </div>
                    <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                </div>
            </div>
            <div class="topping_main in_detail">
                <div class="breadcrumbs">
                    <div class="breadcrumbs_inner">
                        <i class="icon_story"></i>
                        <a href="<?= website_url('designers/home').'?designerId='.$row->designerId ?>">Designer</a><span>/</span><span class="current">Designer Profile</span>
                    </div>
                </div>
                <div class="designer_info">
                    <div class="profile_picture">
                        <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                        <div class="pic" style="background-image: url(<?= backend_url($row->designiconImg) ?>);">
                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                        </div>
                        <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                    </div>
                    <div class="text">
                        <div class="designer_name">
                            <?php if($row->grade == 1){ ?>
                                <!--↓ 知名設計才會有鑽石icon ↓-->
                                <i class="icon_diamond_b"></i>
                                <!--↑ 知名設計才會有鑽石icon ↑-->
                            <?php } ?>
                            <span><?= $row->name ?></span>
                        </div>
                        <div class="country"><img class="flag" src="<?= base_url('assets/images/flag/'.$row->country.'.png') ?>"><span><?= get_all_country($row->country) ?></span></div>
                    </div>
                    <a class="btn_favorite <?= ($like != false) ? 'active' : '' ?>" href="javascript:;" data-designerId="<?= $row->designerId ?>" title="Favorite">
                        <i class="icon_favorite_heart"></i><span>(<span class="count"><?= $likecount ?></span>)</span>
                    </a>
                </div>
                <div class="intro_text">
                    <?= nl2br($row->description) ?>
                </div>
                <div class="share_links">Share
                    <a class="facebook" href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a>
                    <a class="pinterest" href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="designer_profile_story page_block">
        <div class="block_inner">
            <h2 class="block_title"><?= $row->my_story_title ?></h2>
            <div class="block_main">
                <?= $row->my_story_content ?>
            </div>
        </div>
    </div>
    <div class="designer_profile_brands page_block">
        <div class="block_inner">
            <h2 class="block_title">My Brands</h2>
            <div class="block_main">
                <div class="brands_items">
                    <?php if($brandList){
                        foreach ($brandList as $brandKey => $brandValue){ ?>
                            <div class="item">
                                <a href="brand_story.html">
                                    <div class="thumb">
                                        <!--↓ 4:3，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                        <div class="pic" style="background-image: url(<?= backend_url($brandValue->brandImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_4x3.png') ?>"></div>
                                        <!--↑ 4:3，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                    </div>
                                    <div class="brand_name">
                                        <div class="brand_logo">
                                            <div class="pic" style="background-image: url(<?= backend_url($brandValue->brandiconImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                        </div>
                                        <h3><?= $brandValue->name ?></h3>
                                    </div>
                                </a>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</main>
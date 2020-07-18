<div class="designer_banner banner_slider">
    <?php if(!empty($designer_bannerList)){ 
        foreach($designer_bannerList as $designer_bannerKey => $designer_bannerValue){?>
            <div class="slide">
                <img src="<?= backend_url($designer_bannerValue->bannerImg) ?>" alt="">
            </div>
        <?php }
    } ?>    
</div>
<div class="designer_header">
    <div class="designer_header_inner">
        <div class="designer_header_mian">
            <a class="designer_info" href="<?= website_url('designers/profile').'?designerId='.$row->designerId ?>">
                <div class="profile_picture">
                    <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(<?= backend_url($row->designiconImg) ?>)">
                        <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                    </div>
                    <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                </div>
                <div class="text">
                    <div class="designer_name">
                    <!--↓ 知名設計才會有鑽石icon ↓--><?= $row->grade == 1 ? '<i class="icon_diamond_b"></i>' : '' ?>
                    <!--↑ 知名設計才會有鑽石icon ↑--><span><?= $row->name ?></span>
                    </div>
                    <div class="country"><img class="flag" src="<?= base_url('assets/images/flag/'.$row->country.'.png') ?>"><span><?= get_all_country($row->country) ?></span></div>
                </div>
            </a>            
            <ul class="links">
                <li><a href="<?= $row->url ?>" title="Blog" target="_blank"><i class="icon_blog"></i><span>Blog</span></a></li>
                <li><a class="popup" href="<?= website_url('designers/just_popup/'.$row->designerId) ?>" title="Just for you"><i class="icon_just_for_you"></i><span>Just for you</span></a></li>
                <li><a class="popup" href="<?= website_url('designers/message_popup/'.$row->designerId) ?>" title="Message"><i class="icon_message"></i><span>Message</span></a></li>
                <li><a class="btn_favorite <?= ($like != false) ? 'active' : '' ?>" href="javascript:;" data-designerId="<?= $row->designerId ?>" title="Favorite"><i class="icon_favorite_heart_big"></i><span>(<span class="count"><?= $likecount ?></span>)</span></a></li>
                <li><a class="popup" href="popup_gift.html" title="Gift Designer"><i class="icon_gift_designer"></i><span>Gift Designer</span></a></li>
                <li><a class="popup" href="popup_makeWish.html" title="Make a Wish"><i class="icon_make_wish"></i><span>Make a Wish</span></a></li>
            </ul>
        </div>
        <div class="designer_navigation">
            <div class="designer_navigation_inner">
                <div class="reviews">
                    <a href="designer_review.html">
                        <i class="icon_star_full_big"></i>
                        <span class="score">4.8</span>
                        <span class="count">(232 Reviews)</span>
                    </a>
                </div>
                <div class="nav_menu">
                    <ul> 
                        <li><a <?= (stripos($_SERVER['REQUEST_URI'], 'home') ? 'current active' : '') ? 'class="current"' : '' ?> href="<?= website_url('designers/home').'?designerId='.$row->designerId ?>">Home</a></li>
                        <li><a href="javascript:;">Brands of <?= $row->name ?></a>
                            <ul>
                                <?php 
                                if(!empty($brandList)) {
                                    foreach ($brandList as $brandKey => $brandValue) { 
                                ?>
                                    <li><a href="<?= website_url('brand/story?brandId='.$brandValue->brandId); ?>"><?= $brandValue->name ?></a></li>
                                <?php 
                                    }
                                } 
                                ?>
                            </ul>
                        </li>
                        <li><a href="<?= website_url('designers/profile').'?designerId='.$row->designerId ?>"><?= $row->name ?></a></li>
                        <li><a <?= (stripos($_SERVER['REQUEST_URI'], 'product') ? 'current active' : '') ? 'class="current"' : '' ?> href="<?= website_url('designers/product').'?designerId='.$row->designerId ?>">Product</a></li>
                        <li><a <?= (stripos($_SERVER['REQUEST_URI'], 'review') ? 'current active' : '') ? 'class="current"' : '' ?> href="<?= website_url('designers/review').'?designerId='.$row->designerId ?>">Review</a></li>
                    </ul>
                    <a class="toggle_menu" href="javascript:;">Menu</a>
                </div>
            </div>
        </div>
    </div>
</div>




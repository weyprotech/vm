<main id="main">
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
                <a class="designer_info" href="designer_profile.html">
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
                    <li><a href="designer_blog.html" title="Blog" target="_blank"><i class="icon_blog"></i><span>Blog</span></a></li>
                    <li><a class="popup" href="popup_justForYou.html" title="Just for you"><i class="icon_just_for_you"></i><span>Just for you</span></a></li>
                    <li><a class="popup" href="popup_message.html" title="Message"><i class="icon_message"></i><span>Message</span></a></li>
                    <li><a class="btn_favorite" href="javascript:;" data-designerId="designer001" title="Favorite"><i class="icon_favorite_heart_big"></i><span>(<span class="count">1207</span>)</span></a></li>
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
                            <li><a class="current" href="<?= website_url('designers/home').'?designerId='.$row->designerId ?>">Home</a></li>
                            <li><a href="<?= website_url('designers/profile').'?designerId='.$row->designerId ?>">Designer Profile</a></li>
                            <li><a href="javascript:;">Brand Story</a>
                                <ul>
                                    <?php foreach ($brandList as $brandKey => $brandValue){ ?>
                                        <li><a href="<?= website_url('brand/story?brandId='.$brandValue->brandId); ?>"><?= $brandValue->name ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li><a href="designer_products.html">Product</a></li>
                            <li><a href="designer_review.html">Review</a></li>
                        </ul>
                        <a class="toggle_menu" href="javascript:;">Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="designer_about page_block">
        <div class="block_inner">
        <div class="designer_about_image">
            <div class="thumb">
                <div class="pic" style="background-image: url(<?= backend_url($row->aboutImg) ?>)"><img class="size" src="<?= base_url('assets/images/size_4x3.png') ?>"></div>
            </div>
        </div>
        <div class="designer_about_intro">
            <h2 class="block_title">About Designer</h2>
            <div class="text">
                <?php @$temp = explode('<br>',$row->description); ?>
                <?= @$temp[0] ?>
            </div><a class="btn common more" href="<?= website_url('designers/profile').'?designerId='.$row->designerId ?>">My Profile</a>
        </div>
        </div>
    </div>
    <?php if(!empty($runway)){ ?>
        <div class="designer_event page_block">
            <div class="block_inner">
                <?php if($runway->live == 1){ ?>
                    <!-- ↓ 直播影片的時候使用 ↓-->            
                    <div class="event_video fit_video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= youtube_id($runway->live_youtube) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>           
                    <!-- ↑ 直播影片的時候使用 ↑-->
                <?php }else{ ?>
                    <!-- ↓ 倒數期間使用 ↓-->
                    <div class="event_countdown">
                        <h2 class="block_title">RUNWAY<br>NEW EVENT</h2>
                        <div class="countdown" data-date="<?= $runway->date ?>" data-time="<?= $runway->time ?>"></div>
                    </div>
                    <!-- ↑ 倒數期間使用 ↑-->
                <?php } ?>
                <div class="event_content">
                    <h3 class="event_title"><?= @$runway->title ?></h3>
                    <div class="event_time"><i class="dot"></i>Collection on <?= $runway->date ?> <?= $runway->time ?></div>
                    <div class="text"><?= $runway->content ?></div>
                    <?php if($runway->live != 1){ ?>
                        <!-- ↓ 直播影片的時候不放 ↓--><a class="thumb is_video popup" href="<?= website_url('designers/popup/event/'.$runway->runwayId) ?>">
                        <div class="pic" style="background-image: url(<?= backend_url(@$runway_imgList[0]->runwayImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_16x9.png') ?>"></div></a>
                        <!-- ↑ 直播影片的時候不放 ↑-->
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>    
    <div class="designer_hometown page_block">
        <div class="block_inner">
            <div class="designer_hometown_main">
                <h2 class="block_title"><?= $row->hometown_title ?></h2>
                <div class="country_city"><img class="flag" src="<?= base_url('assets/images/flag/'.$row->hometown_country.'.png') ?>"><span><?= get_all_country($row->hometown_country) ?>, <?= $row->hometown_area ?></span></div>
                <div class="intro_text"><?= $row->hometown_content ?></div>
                <div class="hometown_characteristics">
                    <?php for($i=1;$i<4;$i++){ 
                        $hometown_post_img = 'hometownpost'.$i.'Img';
                        $hometown_post_title = 'hometown_post'.$i.'_title';
                        $hometown_post_content = 'hometown_post'.$i.'_content';
                        ?>
                        <div class="item">
                            <div class="thumb">
                                <div class="pic" style="background-image: url(<?= backend_url($row->$hometown_post_img) ?>);"><img class="size" src="<?= base_url('assets/images/size_4x3.png') ?>"></div>
                            </div>
                            <h3><?= $row->$hometown_post_title ?></h3>
                            <div class="text"><?= $row->$hometown_post_content ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($postList)){ ?>
        <div class="designer_posts page_block" data-anchor="posts">
            <div class="block_inner">
                <h2 class="block_title">My Post</h2>
                <div class="block_main">
                    <?php foreach($postList as $postKey => $postValue){ ?>
                        <div class="post_block">
                            <div class="post_main">
                                <div class="post_content">
                                    <h3 class="post_title"><?= $postValue->title ?></h3>
                                    <time class="date"><?= $postValue->update_at ?></time>
                                    <div class="text"><?= $postValue->content ?></div>
                                </div>
                                <?php if($postValue->imgList){ ?>
                                    <div class="post_media">
                                        <a class="thumb <?= count($postValue->imgList) > 1 ? 'has_more' : (!empty($postValue->imgList[0]->youtube) ? 'is_video' : '') ?> popup" href="<?= website_url('designers/popup/post/'.$postValue->postId) ?>">
                                            <div class="pic" style="background-image: url(<?= backend_url($postValue->imgList[0]->postImg) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_16x9.png') ?>">
                                            </div>                                    
                                            <?php if(count($postValue->imgList) > 1){ ?>
                                                <div class="btn common">More +</div>
                                            <?php } ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="comments_block">
                                <div class="comments_title"><i class="icon_msg"></i>
                                    <h2><?= is_array($postValue->message) ? count($postValue->message) : 0 ?> comments</h2><i class="arrow_down"></i>
                                </div>
                                <div class="comments_content">
                                    <!-- <div class="comments_form">
                                        <div class="profile_picture">
                                            <div class="pic" style="background-image: url(https://source.unsplash.com/rDEOVtE7vOs/100x100);">
                                                <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                            </div>
                                        </div>
                                        <div class="controls">
                                            <input type="text" placeholder="Leave us a message...">
                                            <button type="button">Send</button>
                                        </div>
                                    </div> -->
                                    <div class="comments_messages">
                                        <?php if(!empty($postValue->message)):
                                            foreach ($postValue->message as $messageKey => $messageValue): ?>
                                                <div class="item">
                                                    <div class="msg">
                                                        <div class="profile_picture">
                                                            
                                                        <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                                        </div>
                                                        <div class="msg_content">
                                                        <div class="title">
                                                            <div class="name">Lily Allen</div>
                                                            <div class="divide_line"></div>
                                                            <div class="time"><?= $messageValue->create_at ?></div>
                                                        </div>
                                                        <div class="text"><?= $messageValue->message ?></div>
                                                        </div>
                                                    </div>
                                                    <?php if(!empty($messageValue->response)){ ?>
                                                        <div class="msg reply">
                                                            <div class="profile_picture">
                                                            <div class="pic" style="background-image: url(<?= backend_url($row->designiconImg) ?>);">
                                                                <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                            </div>
                                                            </div>
                                                            <div class="msg_content">
                                                            <div class="title">
                                                                <div class="name">Reply</div>
                                                                <div class="divide_line"></div>
                                                                <div class="time"><?= $messageValue->update_at ?></div>
                                                            </div>
                                                            <div class="text"><?= $messageValue->response ?></div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php endforeach;
                                        endif; ?>
                                    </div>
                                    <a class="open_comments" href="javascript:;">See more comments</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</main>

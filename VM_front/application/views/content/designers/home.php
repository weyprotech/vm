<main id="main">
    <?= $link ?>
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

<main id="main">
    <div class="topping_block brandStory_topping">
        <div class="block_inner">
            <div class="topping_header">
                <div class="brandStory_topping_header">
                    <div class="thumb">
                        <div class="pic" style="background-image: url(<?= backend_url($row->brandImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_4x3.png') ?>"></div>
                    </div>
                    <div class="designer_name">
                        <a href="<?= website_url('designers/home').'?designerId='.$row->designerId ?>">
                            <div class="profile_picture">
                                <div class="pic" style="background-image: url(<?= backend_url($designer->designiconImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                            </div>
                            <span><?= $designer->name ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="topping_main in_detail">
                <div class="breadcrumbs">
                    <div class="breadcrumbs_inner">
                        <i class="icon_story"></i>
                        <a href="<?= website_url('designers/home?designerId='.$designer->designerId) ?>"><?= langText('brand','designer') ?></a>
                        <span>/</span><span class="current"><?= langText('brand','brand') ?></span>
                    </div>
                </div>
                <div class="brand_name">
                    <div class="brand_logo">
                        <div class="pic" style="background-image: url(<?= backend_url($row->brandiconImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                    </div>
                    <h2><?= $row->name ?></h2>
                </div>
                <div class="intro_text">
                    <p class="first_up"><?= nl2br($row->content) ?></p>
                </div>
                <div class="share_links">
                    Share<a class="facebook" href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a>
                    <a class="pinterest" href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($brandBanner)){ ?>
        <div class="brandStory_slider banner_slider">
            <?php foreach($brandBanner as $brandKey => $brandValue){ ?>
                <div class="slide"><img src="<?= backend_url($brandValue->bannerImg) ?>"></div>
            <?php } ?>        
        </div>
    <?php } ?>
    <?php if($row->brand_story_title != '' && $row->brand_story_content != '') {?>
    <div class="brandStory_article article_center_block page_block">
        <div class="block_inner">
            <h2 class="block_title"><?= $row->brand_story_title ?></h2>
            <div class="block_main fit_video">
                <?= $row->brand_story_content ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="brandStory_wall">
        <div class="grid_sizer"></div>
        <div class="gutter_sizer"></div>
        <?php if($row->brandstory2_1Img != '') {?>
        <div class="item">
            <!-- 940px * 1154px--><img src="<?= backend_url($row->brandstory2_1Img) ?>">
        </div>
        <div class="item">
            <div class="wall_words">
                <h2 class="block_title"><?= $row->brand_story_title2 ?></h2>
                <div class="text">
                    <?= nl2br($row->brand_story_content2) ?>
                </div>
            </div>
        </div>
        <?php }?>
        <?php if($row->brandstory2_2Img != '') {?>
        <div class="item">
            <!-- 940px * 968px--><img src="<?= backend_url($row->brandstory2_2Img) ?>">
        </div>
        <?php }?>
        <?php if($row->brandstory2_3Img != '') {?>
        <div class="item">
            <!-- 940px * 865px--><img src="<?= backend_url($row->brandstory2_3Img) ?>">
        </div>
        <?php }?>
        <div class="item">
            <div class="designer_link">
                <h3><?= langText('brand','brand_designer') ?></h3>
                <a class="btn common more" href="<?= website_url('designers/home').'?designerId='.$row->designerId ?>"><?= langText('brand','find_out') ?></a>
            </div>
        </div>
    </div>
    <?php if($productList){ ?>
        <div class="shop_look page_block">
            <div class="block_inner">
                <h2 class="block_title"><?= langText('brand','shop_the_look') ?></h2>
                <div class="block_main">
                    <div class="products_list">
                        <?php foreach ($productList as $productKey => $productValue){ ?>
                            <div class="item">
                                <a href="<?= website_url('product/detail').'?productId='.$productValue->productId ?>">
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($productValue->productImg) ?>)">
                                            <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                        </div>
                                    </div>
                                    <h3><?= $productValue->name ?></h3>
                                    <div class="price"><?= strtoupper($money_type) ?>$ <?= round($productValue->price * $currency) ?></div>
                                </a>
                            </div>
                        <?php } ?>
                    </div><a class="btn common more" href="<?= website_url('product/brand_product').'?brandId='.$row->brandId  ?>"><?= langText('brand','all_products') ?></a>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if($postList){ ?>
        <div class="related_post page_block">
            <div class="block_inner">
            <h2 class="block_title"><?= langText('brand','related_post') ?></h2>
            <div class="block_main">
                <div class="related_post_list scrollbar_x">
                    <?php foreach ($postList as $postKey => $postValue){ 
                        if(!empty($postValue)){?>
                            <div class="item">
                                <a href="<?= website_url('designers/home').'?designerId='.$row->designerId ?>">
                                    <?php $temp = explode(' ',$postValue->create_at); ?>
                                    <div class="date"><?= $temp[0] ?></div>
                                    <div class="thumb <?= empty($postValue->imglist[0]->youtube) ? 'is_video' : '' ?>">
                                        <div class="pic" style="background-image: url(<?= backend_url(@$postValue->imglist[0]->postImg) ?>)">
                                            <img class="size" src="<?= base_url('assets/images/size_16x9.png') ?>">
                                        </div>
                                    </div>
                                    <p><?= $postValue->title ?></p>
                                </a>
                            </div>
                        <?php }
                    } ?>
                </div><a class="btn common more" href="<?= website_url('designers/home').'?designerId='.$row->designerId ?>"><?= langText('brand','view_all') ?></a>
            </div>
            </div>
        </div>
    <?php } ?>
    <div class="message_wrapper page_block">
        <div class="block_inner">
            <h2 class="block_title"><?= langText('brand','messages') ?></h2>
            <div class="block_main">
                <div class="comments_block message_block">
                    <div class="comments_content">
                        <?php if(isset($this->session->userdata('memberinfo')['memberId'])){  ?>
                            <div class="comments_form">
                                <div class="profile_picture">
                                    <div class="pic" style="background-image: url(<?= backend_url($this->session->userdata('memberinfo')['memberImg']) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                </div>
                                <div class="controls">
                                    <textarea placeholder="Leave us a message…"></textarea>
                                    <button type="button" class="brand_message" data-brandid="<?= $row->brandId ?>"><?= langText('brand','send') ?></button>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="comments_messages">
                            <?php if(!empty($messageList)){
                                foreach($messageList as $messageKey => $messageValue){ ?>
                                    <div class="item">
                                        <div class="msg">
                                            <div class="profile_picture">
                                                <div class="pic" style="background-image: url(<?= backend_url($messageValue->memberImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                            </div>
                                            <div class="msg_content">
                                                <div class="title">
                                                <div class="name"><?= $messageValue->last_name.$messageValue->first_name ?></div>
                                                <div class="divide_line"></div>
                                                <?php $date = explode(" ",$messageValue->create_at); ?>
                                                <div class="time"><?= $date[0] ?></div>
                                                </div>
                                                <div class="text"><?= $messageValue->message ?></div>
                                            </div>
                                        </div>
                                        <?php if(!empty($messageValue->response)){ ?>
                                            <div class="msg reply">
                                                <div class="profile_picture">
                                                    <div class="pic" style="background-image: url(<?= backend_url($row->brandiconImg) ?>);">
                                                        <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                    </div>
                                                </div>
                                                <div class="msg_content">
                                                    <div class="title">
                                                    <div class="name"><?= langText('brand','reply') ?></div>
                                                    <div class="divide_line"></div>
                                                    <div class="time"><?= $messageValue->update_at ?></div>
                                                    </div>
                                                    <div class="text"><?= $messageValue->response ?></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <!-- <a class="btn common more" href="javascript:;">All Messages</a> -->
            </div>
        </div>
    </div>
</main>
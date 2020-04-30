<main id="main">
    <div class="breadcrumbs pb_none">
        <div class="breadcrumbs_inner">
            <a href="<?= website_url('product/index').'?baseId='.$base_category->categoryId ?>"><?= $base_category->name ?></a><span>/</span>
            <a href="<?= website_url('product/index').'?subId='.$sub_category->categoryId ?>"><?= $sub_category->name ?></a><span>/</span>
            <a href="<?= website_url('product/index').'?categoryId='.$category->categoryId ?>"><?= $category->name ?></a><span>/</span>
        </div>
    </div>
    <div class="product_showcase page_block">
        <div class="block_inner">
            <div class="showcase_slider_wrapper">
                <div class="showcase_nav">
                    <?php if($product_banner){
                        foreach($product_banner as $bannerKey => $bannerValue){ ?>
                            <div class="slide">
                                <div class="thumb">
                                    <div class="pic" style="background-image: url(<?= backend_url($bannerValue->small_thumbPath) ?>)">
                                        <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>                    
                </div>
                <div class="showcase_slider">
                    <?php if($product_banner){
                        foreach($product_banner as $bannerKey => $bannerValue){ ?>
                            <div class="slide">
                                <a class="thumb popup" href="<?= website_url('product/popup_detail/'.$row->productId) ?>" data-index="0">
                                    <div class="pic" style="background-image: url(<?= backend_url($bannerValue->middle_thumbPath) ?>)">
                                        <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                    </div>
                                </a>
                            </div>
                        <?php }
                    } ?>                    
                </div>
                <div class="share_links">Share
                    <a class="facebook" href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a>
                    <a class="pinterest" href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a>
                </div>
            </div>
            <div class="showcase_content">
                <h1 class="product_title"><?= $row->name ?></h1>
                <div class="product_intro"><?= $row->introduction ?></div>
                <div class="product_price">
                    <?php if(!$sale){ ?>
                        $<?= $row->price ?>
                    <?php }else{ ?>
                        <span class="strikethrough">$<?= $row->price ?></span>
                        <span class="sale_price">$<?= (($row->price)-($row->price*($saleinformation->discount/100))) ?></span>
                    <?php } ?>
                </div>
                <div class="products_sku">
                    <div class="controls_group">
                        <label>Size</label>
                        <div class="controls">
                            <div class="select_wrapper">
                                <select>
                                    <?php if($product_size){
                                        foreach($product_size as $sizeKey => $sizeValue){ ?>
                                            <option value="<?= $sizeValue->Id ?>"><?= $sizeValue->size ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="note">(size guide)</div>
                        </div>
                    </div>
                    <div class="controls_group">
                        <label>Color</label>
                        <div class="controls">
                            <div class="select_wrapper">
                                <select>
                                    <option>Select a color</option>
                                    <?php if($product_color){
                                        foreach($product_color as $colorKey => $colorValue){ ?>
                                            <option value="<?= $colorValue->colorId ?>"><?= $colorValue->color ?></option>
                                        <?php } 
                                    } ?>                                
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="controls_group">
                        <label>Quantity</label>
                        <div class="controls">
                            <div class="quantity_counter">
                                <button class="minus" type="button">&minus;</button>
                                <input class="quantity" type="number" value="1" min="1" readOnly="true">
                                <button class="plus" type="button">&plus;</button>
                            </div>
                        </div>
                    </div>
                    <div class="call_action">
                        <?php if($row->status == 0){ ?>
                            <button class="btn confirm" type="button">Add to cart</button>
                        <?php }else{ ?>
                            <!-- ↓ 如果是預購改用這個 button ↓-->
                            <button class="btn" type="button">Preorder Now</button>
                            <!--↑ 如果是預購改用這個 button ↑ -->
                        <?php } ?>
                        <!--↓ class 加 'active' 表示加入最愛 ↓-->
                        <a class="btn_favorite <?= $like != false ? 'active' : '' ?>" href="javascript:;" data-productId="<?= $row->productId ?>" title="Favorite"><i class="icon_favorite_heart"></i></a>
                        <!--↑ class 加 'active' 表示加入最愛 ↑-->
                    </div>
                </div>
                <div class="products_fold fold_block">
                    <div class="fold">
                        <div class="fold_title active">Product Details</div>
                        <div class="fold_content active">
                            <ul>
                                <?= $row->description ?>                                
                            </ul>
                        </div>
                    </div>
                    <div class="fold">
                        <div class="fold_title">Shipping &nbsp; Returns</div>
                        <div class="fold_content"><?= $row->return ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product_detail_reviews page_block">
        <div class="block_inner">
        <div class="tabber_wrapper">
            <div class="tabber-selectors">
                <div class="sort_menu">
                    <ul>
                        <li><a class="tabber-anchor active" href="javascript:;">Product Detail</a></li>
                        <li><a class="tabber-anchor" href="javascript:;">Reviews</a></li>
                    </ul>
                </div>
            </div>
            <div class="tabber-contents">
                <div class="tabber-content active">
                    <div class="product_detail">
                        <?= $row->detail ?>
                    </div>
                </div>
                <div class="tabber-content">
                    <div class="product_reviews">
                        <div class="reviews_title">
                            <span class="score">4.8</span>
                            <div class="rate_star" data-rateyo-read-only="true" data-rateyo-star-width="24px" data-rateyo-rating="4.5"></div>
                            <span class="count">(0 Reviews)</span>
                        </div>
                        <div class="reviews_wrapper">
                            <?php if($reviewList){
                                foreach($reviewList as $reviewKey => $reviewValue){?>
                                    <div class="item">
                                        <div class="review">
                                            <div class="review_content">
                                                <div class="user_info">
                                                    <div class="profile_picture">
                                                        <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);">
                                                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                        </div>
                                                    </div>
                                                    <div class="title">
                                                        <div class="name">Lily Allen</div>
                                                    </div>
                                                </div>
                                                <!-- <div class="purchase_info">Size: <span>L</span> &nbsp; &nbsp; &nbsp;Color: <span>White</span></div> -->
                                                <div class="rate_date">
                                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="5"></div>
                                                    <div class="date">2019.08.01</div>
                                                </div>
                                                <div class="text">Nice! Comfort!</div>
                                            </div>
                                        </div>
                                        <?php if(!empty($reviewValue->response)){ ?>
                                            <div class="review reply">
                                                <div class="review_content">
                                                    <div class="user_info">
                                                        <div class="profile_picture">
                                                            <div class="pic" style="background-image: url(images/img_profile.jpg);">
                                                                <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="title">
                                                            <div class="name">Lily Allen</div>
                                                            <div class="divide_line"></div><span>Reply</span>
                                                            <div class="divide_line"></div><span>2019.08.01</span>
                                                        </div>
                                                    </div>
                                                    <div class="text">Thank you ：）</div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php }
                            } ?>                                                                                                    
                        </div>
                        <div class="pager_bar">
                            <div class="pages">Page <?= $reviewpage ?> of <?= $total_review_page ?></div>
                            <ul class="pager_navigation">
                            <li class="prev"><a href="javascript:;">&lt; Previous</a></li>
                            <?php for($i=1;$i<=$total_review_page;$i++){ ?>
                                <li <?= $i == $reviewpage ? 'class="current"' : '' ?>><a href="javascript:;"><?= $i ?></a></li>
                            <?php } ?>
                            <li class="next"><a href="javascript:;">Next &gt;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="product_about">
        <div class="designer_banner banner_slider">
            <?php if($designer_bannerList){
                foreach($designer_bannerList as $bannerKey => $bannerValue){ ?>
                    <div class="slide"><img src="<?= backend_url($bannerValue->bannerImg) ?>" alt=""></div>
                <?php }
            } ?>
        </div>
        <div class="tabber_wrapper">
            <div class="tabber-selectors">
                <div class="sort_menu">
                    <ul>
                        <li><a class="tabber-anchor active" href="javascript:;">About Designer</a></li>
                        <li><a class="tabber-anchor" href="javascript:;">Manufacture</a></li>
                        <li><a class="tabber-anchor" href="javascript:;">Fabric</a></li>
                    </ul>
                </div>
            </div>
            <div class="tabber-contents">
                <div class="tabber-content active">
                    <div class="product_about_designer">
                        <div class="designer_introduction">
                            <div class="intro_content">
                                <div class="designer_info">
                                    <a href="designer_profile.html">
                                        <div class="profile_picture">
                                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url($designer->designiconImg) ?>)"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </div>
                                        <div class="text">
                                            <div class="designer_name">
                                                <?php if($designer->grade == 1){ ?>
                                                    <!--↓ 知名設計才會有鑽石icon ↓--><i class="icon_diamond_b"></i>
                                                <?php } ?>
                                                <span><?= $designer->name ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="intro_text">
                                    <?php @$temp = explode('<br>',$designer->description); ?>
                                    <?= @$temp[0] ?>                                    
                                </div>
                                <a class="btn common" href="<?= website_url('designers/home').'?designerId='.$designer->designerId ?>">view more</a>
                                <hr>
                                <h2 class="subtitle"><?= $brand->name ?></h2>
                                <div class="intro_text">
                                    <?php @$brand_temp = explode('<br>',$brand->content); ?>
                                    <?= @$brand_temp[0] ?>                                    
                                </div>
                                <a class="btn common" href="<?= website_url('brand/story').'?brandId='.$brand->brandId ?>">brand story</a>
                            </div>
                            <div class="intro_image">
                                <div class="thumb">
                                <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                <div class="pic" style="background-image: url(<?= backend_url($designer->designImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                </div>
                            </div>
                        </div>
                        <?php if($postList){ ?>
                            <div class="latest_post">
                                <h2 class="subtitle">Latest Post</h2>
                                <div class="post_block_wrapper">                                
                                    <?php foreach($postList as $postKey => $postValue){ ?>
                                        <div class="post_block">
                                            <div class="post_main">
                                                <div class="post_content">
                                                    <h3 class="post_title"><?= $postValue->title ?></h3>
                                                    <time class="date"><?= $postValue->update_at ?></time>
                                                    <div class="text"><?= $postValue->content ?></div>
                                                </div>
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
                                            </div>
                                            <div class="comments_block">
                                                <div class="comments_title"><i class="icon_msg"></i>
                                                    <h2><?= is_array($postValue->message) ? count($postValue->message) : 0 ?> comments</h2><i class="arrow_down"></i>
                                                </div>
                                                <div class="comments_content">
                                                    <div class="comments_form">
                                                        <div class="profile_picture">
                                                            <div class="pic" style="background-image: url(https://source.unsplash.com/rDEOVtE7vOs/100x100);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                                        </div>
                                                        <div class="controls">
                                                            <input type="text" placeholder="Leave us a message...">
                                                            <button type="button">Send</button>
                                                        </div>
                                                    </div>
                                                    <div class="comments_messages">
                                                        <?php if(!empty($postValue->message)):
                                                            foreach ($postValue->message as $messageKey => $messageValue): ?>
                                                                <div class="item">
                                                                    <div class="msg">
                                                                        <div class="profile_picture">
                                                                            <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
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
                                <a class="btn common more" href="<?= website_url('designers/home').'?designerId='.$designer->designerId ?>#posts">view more</a>
                            </div>
                        <?php } ?>
                    </div>    
                </div>            
                <div class="tabber-content">
                <div class="product_about_cooperate">
                    <h2 class="title"><?= @$manufacture->main_title ?></h2>
                    <div class="banner"><img src="<?= backend_url(@$manufacture->firstbannerImg)  ?>"></div>
                    <div class="cooperate_block">
                        <div class="block_inner">
                            <div class="cooperate_introduction">
                                <div class="intro_block">
                                    <div class="intro_image">
                                        <div class="thumb">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url(@$manufacture->content1Img) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                            </div>
                                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </div>
                                    </div>
                                    <div class="intro_content">
                                        <div class="intro_head">
                                            <div class="thumb">
                                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url(@$manufacture->iconImg) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                            </div>
                                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                            </div>
                                            <div class="location"><i class="icon_map_marker"></i><span><?= @$manufacture->location ?></span></div>
                                        </div>
                                        <h3 class="subtitle"><?= @$manufacture->title1 ?></h3>
                                        <div class="text"><?= @$manufacture->content1 ?></div>
                                    </div>
                                </div>
                                <div class="intro_block">
                                    <div class="intro_image">
                                        <div class="thumb">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url(@$manufacture->content2Img) ?>);"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </div>
                                    </div>
                                    <div class="intro_content">
                                        <h3 class="subtitle"><?= @$manufacture->title2 ?></h3>
                                        <div class="text"><?= @$manufacture->content2 ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="banner"><img src="<?= backend_url(@$manufacture->secondbannerImg) ?>"></div>
                    <div class="cooperate_block">
                        <div class="block_inner">
                            <div class="cooperate_brand">
                                <h3 class="subtitle"><?= @$manufacture->title3 ?></h3>
                                <div class="text">
                                    <?= @$manufacture->content3 ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cooperate_wall">
                        <?php for($i=0;$i<3;$i++){
                            $youtube = 'popup'.($i+1).'youtube';
                            $img = 'popup'.($i+1).'Img';?>
                            <div class="item">
                                <a class="thumb <?= (!empty(@$manufacture->$youtube) ? 'is_video' : '') ?> popup" href="<?= website_url('product/popup_manufacture/'.$row->productId) ?>" data-index="<?= $i ?>">
                                    <!--↓ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                    <div class="pic" style="background-image: url(<?= backend_url(@$manufacture->$img) ?>);">
                                        <img class="size" src="<?= base_url('assets/images/size_16x9.png') ?>">
                                    </div>
                                    <!--↑ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                </a>
                            </div>
                        <?php } ?>                        
                        <div class="item cooperate_link">
                            <h3 class="subtitle">Fusce vehicul.</h3>
                            <a class="btn common more" href="javascript:;" target="_blank">Find out</a>
                        </div>
                    </div>
                </div>
                </div>
                <div class="tabber-content">
                <div class="product_about_cooperate">
                    <h2 class="title"><?= @$fabric->main_title ?></h2>
                    <div class="banner"><img src="<?= backend_url(@$fabric->firstbannerImg) ?>"></div>
                    <div class="cooperate_block">
                        <div class="block_inner">
                            <div class="cooperate_introduction">
                                <div class="intro_block">
                                    <div class="intro_image">
                                        <div class="thumb">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url(@$fabric->content1Img) ?>);">
                                            <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </div>
                                    </div>
                                    <div class="intro_content">
                                        <div class="intro_head">
                                            <div class="thumb">
                                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                <div class="pic" style="background-image: url(<?= backend_url(@$fabric->iconImg) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                            </div>
                                            <div class="location"><i class="icon_map_marker"></i><span><?= @$fabric->location ?></span></div>
                                        </div>
                                        <h3 class="subtitle"><?= @$fabric->title1 ?></h3>
                                        <div class="text">
                                            <?= nl2br(@$fabric->content1) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro_block">
                                    <div class="intro_image">
                                        <div class="thumb">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url(@$fabric->content2Img) ?>);">
                                            <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </div>
                                    </div>
                                    <div class="intro_content">
                                        <h3 class="subtitle"><?= @$fabric->title2 ?></h3>
                                        <div class="text">
                                            <?= nl2br(@$fabric->content2) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="banner">
                        <img src="<?= backend_url(@$fabric->secondbannerImg) ?>">
                    </div>
                    <div class="cooperate_block">
                        <div class="block_inner">
                            <div class="cooperate_brand">
                                <h3 class="subtitle"><?= @$fabric->title3 ?></h3>
                                <div class="text">
                                    <?= @$fabric->content3 ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cooperate_wall">
                        <?php for($i=0;$i<3;$i++){
                            $youtube = 'popup'.($i+1).'youtube';
                            $img = 'popup'.($i+1).'Img';?>
                            <div class="item">
                                <a class="thumb <?= (!empty(@$fabric->$youtube) ? 'is_video' : '') ?> popup" href="<?= website_url('product/popup_fabric/'.$row->productId) ?>" data-index="0">
                                    <!--↓ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                    <div class="pic" style="background-image: url(<?= backend_url(@$fabric->$img) ?>);">
                                        <img class="size" src="<?= base_url('assets/images/size_16x9.png') ?>">
                                    </div>
                                    <!--↑ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                </a>
                            </div>
                        <?php } ?>
                    <div class="item cooperate_link">
                        <h3 class="subtitle">Fusce vehicul.</h3>
                        <a class="btn common more" href="javascript:;" target="_blank">Find out</a>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($productList)){ ?>
        <div class="product_related_wrapper page_block bg_gray">
            <div class="block_inner">
                <h2 class="block_title">You may also like</h2>
                <div class="product_list_slider">                
                    <?php for($i=0;$i<8;$i++){ 
                        if(isset($productList[$i])){?>
                            <div class="slide">
                                <a class="slide_inner" href="<?= website_url('product/detail').'?productId='.$productList[$i]->productId ?>">
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($productList[$i]->productImg) ?>)">
                                            <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                        </div>
                                    </div>
                                    <h3><?= $productList[$i]->name ?></h3>
                                    <div class="price">NT$ <?= $productList[$i]->price ?></div>
                                </a>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($viewList)){ ?>
        <div class="product_related_wrapper page_block">
            <div class="block_inner">
                <h2 class="block_title">Recently viewed</h2>
                <div class="product_list_slider">
                    <?php foreach($viewList as $viewKey => $viewValue){ ?>
                        <div class="slide">
                            <a class="slide_inner" href="<?= website_url('product/detail').'?productId='.$viewValue->productId ?>">
                                <div class="thumb">
                                    <div class="pic" style="background-image: url(<?= backend_url($viewValue->productImg) ?>)">
                                        <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                    </div>
                                </div>
                                <h3><?= $viewValue->name ?></h3>
                                <div class="price">NT$ <?= $viewValue->price ?></div>
                            </a>
                        </div>
                    <?php } ?>            
                </div>
            </div>
        </div>
    <?php } ?>
</main>
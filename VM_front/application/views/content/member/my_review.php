<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
        <div class="center_container container">
            <?= $this->load->view('content/member/_aside',array(),true) ?>        
            <div class="container_main">
                <h1 class="block_title">My Reviews</h1>
                <div class="reviews_wrapper has_thumb">
                    <?php if(!empty($reviewList)){
                        foreach($reviewList as $reviewKey => $reviewValue){ ?>
                            <div class="item">
                                <div class="review">
                                    <div class="review_picture">
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= website_url($reviewValue->productImg) ?>);">
                                            <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="review_content">
                                        <div class="product_name"><?= $row->name ?></div>                                   
                                        <div class="rate_date">
                                            <div class="rate_star hide" data-rateyo-read-only="true"></div>
                                            <div class="date">
                                            <!-- 評價完成時顯示日期-->
                                            </div>
                                        </div>
                                        <div class="text">
                                            <!-- 評價完成時顯示評語-->
                                        </div>
                                    </div>
                                    <!--↓ data-reviewid 為評價 ID ↓--><a class="btn common popup_review" data-reviewid="011" href="popup_review.html">Review</a>
                                    <!--↑ data-reviewid 為評價 ID ↑-->
                                </div>
                                <?php if(!empty($reviewValue->response)){ ?>
                                    <div class="review reply">
                                        <div class="review_content">
                                        <div class="user_info">
                                            <div class="profile_picture">
                                            <div class="pic" style="background-image: url(<?= $reviewValue->designer->designiconImg ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                            </div>
                                            <div class="title">
                                            <div class="name"><?= $reviewValue->designer->name ?></div>
                                            <div class="divide_line"></div><span>Reply</span>
                                            <?php $replydate = explode(',', $reviewValue->update_at) ?>
                                            <div class="divide_line"></div><span><?= $replydate[0] ?></span>
                                            </div>
                                        </div>
                                        <div class="text"><?= $reviewValue->response ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }
                    } ?>
                </div>
                <div class="pager_bar">
                    <div class="pages">Page 1 of <?= ceil($reviewCount/6) ?></div>
                    <ul class="pager_navigation">
                    <li class="prev"><a href="javascript:;">&lt; Previous</a></li>
                    <?php for($i = 1;$i<$reviewCount;$i++){ ?>
                        <li <?= ($page == $i ? 'class="current"' : '') ?>><a href="javascript:;"><?= $i ?></a></li>
                    <?php } ?>
                    <li class="next"><a href="javascript:;">Next &gt;</a></li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>
</main>
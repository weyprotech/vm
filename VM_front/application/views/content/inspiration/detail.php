<main id="main">
    <div class="breadcrumbs">
    <div class="breadcrumbs_inner"><a href="index.html">VM</a><span>/</span><a
        href="<?= website_url('inspiration/index') ?>">OOTD</a><span>/</span><span class="current"><?= $row->title ?></span></div>
    </div>
    <div class="detail_wrapper page_block">
    <div class="block_inner">
        <div class="container">
        <div class="container_main">
            <div class="detail_article">
            <h1 class="block_title"><?= $row->title ?></h1>
            <div class="share_info">
                <div class="share_links">Share:
                    <a class="facebook" href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a>
                    <a class="pinterest" href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a>
                    <a class="twitter" href="javascript:;" target="_blank"><i class="icon_share_twitter"></i></a>
                    <a class="weibo" href="javascript:;" target="_blank"><i class="icon_share_weibo"></i></a>
                </div>
                <div class="info">
                <div class="date"><?= (string)str_replace('-','/' , explode(" ",$row->create_at)[0]) ?></div>
                <?php if($this->session->userdata('memberinfo')){ ?>
                    <?php if(!empty($inspiration_like)){ ?>
                        <a class="btn_favorite active" id="inspiration_like" data-ootdId="ootd01" href="javascript:;" onclick="click_like();"><i class="icon_favorite_heart"></i></a>
                    <?php }else{ ?>
                        <a class="btn_favorite" id="inspiration_like" data-ootdId="ootd01" href="javascript:;" onclick="click_like();"><i class="icon_favorite_heart"></i></a>
                    <?php } ?>
                <?php }else{ ?>
                    <a class="btn_favorite" id="inspiration_like" data-ootdId="ootd01" href="javascript:;" onclick="click_like();"><i class="icon_favorite_heart"></i></a>
                <?php } ?>                
                </div>
            </div>
            <div class="article_content">
                <?= $row->Content ?>
            </div>
            </div>
            <div class="comments_block">
            <div class="comments_title"><i class="icon_msg"></i>
                <h2><?= $inspiration_messageCount ?> comments</h2><i class="arrow_down"></i>
            </div>

            <div class="comments_content">
                <?php if($this->session->userdata('memberinfo')){ ?>
                    <form id='inspiration_form' method='post'>
                        <div class="comments_form">
                            <div class="profile_picture">
                                <div class="pic" style="background-image: url(<?= base_url($member->memberImg) ?>);">
                                    <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                </div>
                            </div>
                            <div class="controls">
                                <input type="text" name="message" placeholder="Leave us a message...">
                                <button type="submit">Send</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                
                <div class="comments_messages">
                    <!-- foreach -->
                    <?php foreach($inspiration_messageList as $inspiration_messageValue){ ?>                       
                        <div class="item">
                            <div class="msg">
                                <div class="profile_picture">
                                    <div class="pic" style="background-image: url(<?= backend_url($inspiration_messageValue->memberImg) ?>);">
                                        <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                    </div>
                                </div>
                                <div class="msg_content">
                                    <div class="title">
                                        <div class="name"><?= $inspiration_messageValue->first_name . " " . $inspiration_messageValue->last_name ?></div>
                                        <div class="divide_line"></div>
                                        <div class="time"><?= str_replace("-",".",explode(" ",(string)$inspiration_messageValue->create_at)[0]) . " " . explode(" ",(string)$inspiration_messageValue->create_at)[1]?></div>
                                    </div>
                                    <div class="text"><?= $inspiration_messageValue->message ?></div>
                                </div>
                            </div>
                            <?php if(!empty($inspiration_messageValue->response)){ ?>
                                <div class="msg reply">
                                    <div class="profile_picture">
                                        <div class="pic" style="background-image: url(<?= backend_url($inspiration_messageValue->inspirationImg) ?>);">
                                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                        </div>
                                    </div>
                                    <div class="msg_content">
                                        <div class="title">
                                            <div class="name">Reply</div>
                                            <div class="divide_line"></div>
                                            <div class="time"><?= str_replace("-",".",explode(" ",(string)$inspiration_messageValue->update_at)[0]) . " " . explode(" ",(string)$inspiration_messageValue->update_at)[1]?></div>
                                        </div>
                                        <div class="text"><?= $inspiration_messageValue->response ?></div>
                                    </div>
                                </div>
                            <?php } ?>                            
                        </div>
                    <?php } ?>
                    
                    <!-- Endforeach -->
                </div>
                <a class="open_comments"href="javascript:;">See more comments</a>
            </div>
            </div>
        </div>
        <div class="container_aside">
            <div class="aside_block">
            <h2 class="aside_title">Related Products</h2>
            <div class="aside_products_slider">
                <?php foreach($inspiration_productList as $inspiration_productValue) { ?>
                    <div class="slide">
                        <a href="<?= website_url('product/detail?productId=' . $inspiration_productValue->productId) ?>">
                            <div class="thumb">
                                <div class="pic" style="background-image: url(images/img_product01.jpg)">
                                    <img class="size" src="<?= backend_url($inspiration_productValue->inspirationImg)?>">
                                </div>
                            </div>
                            <div class="text">
                                <h3><?= $inspiration_productValue->title ?></h3>
                                <?php if(!empty($inspiration_productValue->price)){ ?>
                                    <div class="price">
                                        <!-- <span class="strikethrough">NT$ <?= $inspiration_productValue->price ?></span> -->
                                        <span class="sale_price"><?= strtoupper($money_type) ?>$ <?= $inspiration_productValue->price ?></span>
                                    </div>
                                <?php } ?>                                
                            </div>
                        </a>
                    </div>
                <?php } ?>                
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</main>

<script>
    function click_like()
    {
        $.ajax({
            url:'<?= website_url('ajax/inspiration/set_like') ?>',
            type:'post',
            dataType:'json',
            data:{"inspirationId" : "<?= $inspirationId ?>"},
            success: function(response){
                location.reload();
            }
        });
    }
</script>
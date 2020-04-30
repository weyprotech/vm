<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
            <div class="center_container container">
                <?= $this->load->view('content/member/_aside',array(),true) ?>
                <div class="container_main">
                    <h1 class="block_title">My Favorites</h1>
                    <div class="tabber_wrapper point_record_tabber">
                        <div class="tabber-selectors">
                            <div class="sort_menu">
                                <ul>
                                    <li><a class="tabber-anchor active" href="javascript:;">Designers </a></li>
                                    <li><a class="tabber-anchor" href="javascript:;">Products</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tabber-contents">
                            <div class="tabber-content active">
                                <div class="rwd_table">
                                    <div class="thead">
                                        <div class="tr">
                                        <div class="th">Designer</div>
                                        <div class="th">Upcoming Event</div>
                                        <div class="th">&nbsp;</div>
                                        </div>
                                    </div>
                                    <div class="tbody">
                                        <?php if($designerList){
                                            foreach($designerList as $designerKey => $designerValue){ ?>
                                                <div class="tr">
                                                    <div class="td" data-label="Designer">
                                                        <a class="designer_info" href="<?= website_url('designers/home').'?designerId='.$designerValue->designerId ?>">
                                                            <div class="profile_picture">
                                                                <div class="pic" style="background-image: url(<?= backend_url($designerValue->designiconImg) ?>);">
                                                                    <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                                </div>
                                                            </div>
                                                            <div class="di_name"><?= $designerValue->name ?></div>
                                                        </a>
                                                    </div>
                                                    <div class="td" data-label="Upcoming Event">
                                                        <div class="event_info">
                                                            <?php if($designerValue->runway){ ?>
                                                                <div class="date font_khaki"><?= $designerValue->runway[0]->date ?></div>
                                                                <div class="text"><?= $designerValue->runway[0]->title ?></div>
                                                            <?php }else{ ?>                                                                
                                                                <div class="date font_khaki">No event yet</div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="td" data-label="">
                                                        <a class="btn confirm popup" href="popup_gift.html">Gift Designer</a>
                                                    </div>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tabber-content">
                                <div class="rwd_table">
                                    <div class="thead">
                                        <div class="tr">
                                            <div class="th">Product</div>
                                            <div class="th">Designer</div>
                                            <div class="th">&nbsp;</div>
                                        </div>
                                    </div>
                                    <div class="tbody">
                                        <?php if($productList){
                                            foreach($productList as $productKey => $productValue){ ?>
                                                <div class="tr">
                                                    <div class="td" data-label="Product">
                                                        <div class="product_info">
                                                            <a class="thumb" href="<?= website_url('product/detail').'?productId='.$productValue->productId ?>">
                                                                <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                                <div class="pic" style="background-image: url(<?= backend_url($productValue->productImg) ?>);">
                                                                    <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                                </div>
                                                                <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                                            </a>
                                                            <div class="pi_text">
                                                                <div class="pi_name"><?= $productValue->name ?></div>
                                                                <div class="pi_description"><?= $productValue->description ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="td" data-label="Designer">
                                                        <a class="designer_info" href="<?= website_url('designers/home').'?designerId='.$productValue->designerId?>">
                                                            <div class="profile_picture">
                                                                <div class="pic" style="background-image: url(<?= backend_url($productValue->designiconImg) ?>);">
                                                                    <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                                </div>
                                                            </div>
                                                            <div class="di_name"><?= $productValue->designerName ?></div>
                                                        </a>
                                                    </div>
                                                    <div class="td" data-label="">
                                                        <a class="btn confirm" href="<?= website_url('product/detail').'?productId='.$productValue->productId ?>">Product</a>
                                                    </div>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
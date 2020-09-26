<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
        <div class="center_container container">
            <?= $this->load->view('content/member/_aside',array(),true) ?>
            <div class="container_main">
            <h1 class="block_title">My Points</h1>
            <div class="points_display">$<?= $member->point ?></div>
            <h1 class="block_title">Point Record</h1>
            <div class="tabber_wrapper point_record_tabber">
                <div class="tabber-selectors">
                <div class="sort_menu">
                    <ul>
                    <li><a class="tabber-anchor active" href="javascript:;">Point Record </a></li>
                    <li><a class="tabber-anchor" href="javascript:;">Rewards</a></li>
                    </ul>
                </div>
                </div>
                <div class="tabber-contents">
                    <div class="tabber-content active">
                        <div class="rwd_table">
                            <div class="thead">
                                <div class="tr">
                                <div class="th">Date</div>
                                <div class="th">Order</div>
                                <div class="th">Discount / Reward</div>
                                <div class="th">My points</div>
                                </div>
                            </div>
                            <div class="tbody">
                                <?php if(!empty($recordList)){
                                    foreach($recordList as $recordKey => $recordValue){ ?>
                                    <div class="tr">
                                        <div class="td" data-label="Date"><?= $recordValue->date ?></div>
                                        <div class="td" data-label="Order">No:<?= $recordValue->orderId ?></div>
                                        <div class="td" data-label="Discount / Reward"><span class="font_red"><?= $recordValue->record_money ?></span></div>
                                        <div class="td" data-label="My points">$<?= $recordValue->total_money ?></div>
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
                            <div class="th">Date</div>
                            <div class="th">Product</div>
                            <div class="th">Rewards</div>
                            <div class="th">My points</div>
                            </div>
                        </div>
                        <div class="tbody">
                            <?php if(!empty($rewardList)){
                                foreach($rewardList as $rewardKey => $rewardValue){ ?>
                                    <div class="tr">
                                        <div class="td" data-label="Date"><?= $rewardValue->date ?></div>
                                        <div class="td" data-label="Product">
                                        <div class="product_info"><a class="thumb" href="<?= website_url('product/detail').'?productId='.$rewardValue->productId ?>">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url($rewardValue->productImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑--></a>
                                            <div class="pi_text">
                                            <div class="pi_name"><?= $rewardValue->name ?></div>
                                            <div class="pi_description"><?= $rewardValue->introduction ?></div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="td" data-label="Reward"><span class="font_red"><?= $rewardValue->record_money ?></span></div>
                                        <div class="td" data-label="My points">$<?= $rewardValue->total_money ?></div>
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
<main id="main">
    <div class="help_center page_block">
        <div class="block_inner">
            <div class="center_container container">
                <div class="container_aside">
                    <div class="aside_block">
                        <div class="aside_menu fold_block">
                            <div class="fold">
                                <div class="fold_title">Help Center</div>
                                <div class="fold_content">
                                    <ul>
                                    <li><a href="<?= website_url('help/faq') ?>">FAQ</a></li>
                                        <li><a href="<?= website_url('help/delivery') ?>">Delivery</a></li>
                                        <li><a href="<?= website_url('help/exchange') ?>">Refunds &amp; Exchanges</a></li>
                                        <li><a class="current" href="<?= website_url('help/customer') ?>">Customer Service</a></li>
                                        <li><a href="<?= website_url('help/feedback') ?>">Feedback</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container_main">
                    <h1 class="block_title"><?= $customer->title ?></h1>
                    <div class="words">
                        <?= nl2br($customer->content) ?>
                    </div>
                    <div class="social_links">Connect with us:
                        <a href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a>
                        <a href="javascript:;" target="_blank"><i class="icon_share_instagram"></i></a>
                        <a href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a>
                        <a href="javascript:;" target="_blank"><i class="icon_share_twitter"></i></a>
                        <a href="javascript:;" target="_blank"><i class="icon_share_youtube"></i></a>
                        <a href="javascript:;" target="_blank"><i class="icon_share_weibo"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
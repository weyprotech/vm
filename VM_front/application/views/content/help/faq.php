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
                                        <li><a class="current" href="<?= website_url('help/faq') ?>">FAQ</a></li>
                                        <li><a href="<?= website_url('help/delivery') ?>">Delivery</a></li>
                                        <li><a href="<?= website_url('help/exchange') ?>">Refunds &amp; Exchanges</a></li>
                                        <li><a href="<?= website_url('help/customer') ?>">Customer Service</a></li>
                                        <li><a href="<?= website_url('help/feedback') ?>">Feedback</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container_main">
                    <h1 class="block_title">FAQ</h1>
                    <div class="faq_fold fold_block">
                        <?php foreach ($faqList as $faqKey => $faqValue){ ?>
                            <div class="fold">
                                <div class="fold_title"><?= $faqValue->title ?></div>
                                <div class="fold_content"><?= $faqValue->content ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
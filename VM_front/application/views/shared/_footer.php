<footer id="footer">
    <div class="footer_inner">
        <div class="footer_information"><a class="footer_logo" href="index.html"><img class="retina" src="<?= base_url('assets/images/demo/logo_footer.png') ?>"></a>
        <div class="copyright">© 2019 ymyx INC.</div>
        <div class="social_apps_links">
            <div class="social"><a href="mailto:xxx@test.com"><i class="icon_email"></i></a><a href="javascript:;" target="_blank"><i class="icon_facebook"></i></a><a href="javascript:;" target="_blank"><i class="icon_instagram"></i></a></div>
            <div class="apps"><a href="javascript:;" target="_blank"><img src="<?= base_url('assets/images/app_ios.png') ?>"></a><a href="javascript:;" target="_blank"><img src="<?= base_url('assets/images/app_android.png') ?>"></a></div>
        </div>
        <hr><a class="btn cooperation_link" href="javascript:;">Cooperation | Joining | Investment</a><a class="interested_link" href="javascript:;"><i class="icon_hand"></i>Interested in opening a shop here?</a>
        </div>
        <nav class="footer_nav">
        <ul>
            <li>
            <h4><?= langText('footer','company') ?></h4>
            <ul>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'about') ? 'current' : '') ?>" href="<?= website_url('company/about') ?>"><?= langText('footer','about') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'physical_store') ? 'current' : '') ?>" href="<?= website_url('company/physical_store') ?>"><?= langText('footer','physical') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'contact') ? 'current' : '') ?>" href="<?= website_url('company/contact') ?>"><?= langText('footer','contact') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'policy') ? 'current' : '') ?>" href="<?= website_url('company/policy') ?>"><?= langText('footer','terms') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'cooperation') ? 'current' : '') ?>" href="<?= website_url('company/cooperation') ?>"><?= langText('footer','cooperation') ?></a></li>
            </ul>
            </li>
            <li>
            <h4><?= langText('footer','help') ?></h4>
            <ul>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'faq') ? 'current' : '') ?>" href="<?= website_url('help/faq') ?>">FAQ</a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'delivery') ? 'current' : '') ?>" href="<?= website_url('help/delivery') ?>"><?= langText('footer','delivery') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'exchange') ? 'current' : '') ?>" href="<?= website_url('help/exchange') ?>"><?= langText('footer','refunds') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'customer') ? 'current' : '') ?>" href="<?= website_url('help/customer') ?>"><?= langText('footer','customer') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'feedback') ? 'current' : '') ?>" href="<?= website_url('help/feedback') ?>"><?= langText('footer','feedback') ?></a></li>
            </ul>
            </li>
            <li>
            <h4><?= langText('footer','shop') ?></h4>
            <ul>
                <li><a class="<?= ((stripos($_SERVER['REQUEST_URI'],'designers') && !stripos($_SERVER['REQUEST_URI'],'popular_designers')) ? 'current active' : '') ?>" href="<?= website_url('designers') ?>"><?= langText('footer','designers') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'brand') ? 'current active' : '') ?>" href="<?= website_url('brand') ?>"><?= langText('footer','brands') ?></a></li>
                <li><a class="<?= ((stripos($_SERVER['REQUEST_URI'],'events')) && (!stripos($_SERVER['REQUEST_URI'],'type=events')) ? 'current active' : '') ?>" href="<?= website_url('events') ?>"><?= langText('footer','events') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'popular_designers') ? 'current active' : '') ?>" href="<?= website_url('popular_designers') ?>"><?= langText('footer','popular_designers') ?></a></li>
            </ul>
            </li>
            <li>
            <h4><?= langText('footer','product') ?></h4>
            <ul>
                <?php foreach($categoryList as $firstKey => $firstValue){ ?>
                    <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],$firstValue->categoryId) ? 'current active' : '') ?>" href="<?= website_url('product/index?baseId='.$firstValue->categoryId) ?>"><?= $firstValue->name ?></a></li>
                <?php } ?>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'sale') ? 'current active' : '') ?>" href="<?= website_url('sale') ?>"><?= langText('footer','sale') ?></a></li>
            </ul>
            </li>
            <li>
            <h4><?= langText('footer','member') ?></h4>
            <ul>
                <li><a href="<?= website_url('member/favorite') ?>"><?= langText('footer','favorite') ?></a></li>
                <li><a href="<?= website_url('member') ?>"><?= langText('footer','account') ?></a></li>
                <li><a href="<?= website_url('login') ?>"><?= langText('footer','point') ?></a></li>
                <li><a href="<?= website_url('login') ?>"><?= langText('footer','model') ?></a></li>
            </ul>
            </li>
        </ul>
        </nav>
    </div>
</footer>
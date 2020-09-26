<div class="container_aside">
    <div class="aside_block">
        <div class="aside_menu fold_block">
            <div class="fold">
                <div class="fold_title">My Account</div>
                <div class="fold_content">
                    <?php $tmp = explode('/', $_SERVER['REQUEST_URI']); ?>
                    <ul>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'member') ? 'class="current"' : '' ?> href="<?= website_url('member/member') ?>">Account</a></li>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'order_history') ? 'class="current"' : '' ?> href="<?= website_url('member/member/order_history') ?>">Order History</a></li>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'mypoint') ? 'class="current"' : '' ?> href="<?= website_url('member/member/mypoint') ?>">My Points</a></li>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'gift') ? 'class="current"' : '' ?> href="<?= website_url('member/member/gift') ?>">Gift Designer</a></li>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'be_vm_model') ? 'class="current"' : '' ?> href="<?= website_url('member/member/be_vm_model') ?>">Be VM Model</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="fold">
                <div class="fold_title">My Style</div>
                <div class="fold_content">
                    <ul>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'favorite') ? 'class="current"' : '' ?> href="<?= website_url('member/member/favorite') ?>">My Favorite</a></li>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'style_inpsiration') ? 'class="current"' : '' ?> href="<?= website_url('member/member/style_inpsiration') ?>">Style Inspiration</a></li>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'member_reviews') ? 'class="current"' : '' ?> href="<?= website_url('member/member/member_reviews') ?>">My Reviews</a></li>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'member_upcoming') ? 'class="current"' : '' ?> href="<?= website_url('member/member/member_upcoming') ?>">Upcoming Events</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
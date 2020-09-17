<div class="container_aside">
    <div class="aside_block">
        <div class="aside_menu fold_block">
            <div class="fold">
                <div class="fold_title">My Account</div>
                <div class="fold_content">
                    <?php $tmp = explode('/', $_SERVER['REQUEST_URI']); ?>
                    <ul>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'member') ? 'class="current"' : '' ?> href="<?= website_url('member/member') ?>">Account</a></li>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'order_history') ? 'class="current"' : '' ?> href="<?= website_url('member/order_history') ?>">Order History</a></li>
                        <li><a href="member_points.html">My Points</a></li>
                        <li><a href="member_gift.html">Gift Designer</a></li>
                        <li><a href="member_model.html">Be VM Model</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="fold">
                <div class="fold_title">My Style</div>
                <div class="fold_content">
                    <ul>
                        <li><a <?= ($tmp[count($tmp) - 1] == 'favorite') ? 'class="current"' : '' ?> href="<?= website_url('member/member/favorite') ?>">My Favorite</a></li>
                        <li><a href="member_style.html">Style Inpsiration</a></li>
                        <li><a href="member_reviews.html">My Reviews</a></li>
                        <li><a href="member_upcoming.html">Upcoming Events</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
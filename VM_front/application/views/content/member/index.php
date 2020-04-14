<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
            <div class="center_container container">
                <div class="container_aside">
                    <div class="aside_block">
                        <div class="aside_menu fold_block">
                            <div class="fold">
                                <div class="fold_title">My Account</div>
                                <div class="fold_content">
                                    <ul>
                                        <li><a class="current" href="member_account.html">Account</a></li>
                                        <li><a href="member_history.html">Order History</a></li>
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
                                        <li><a href="member_favorite.html">My Favorite</a></li>
                                        <li><a href="member_style.html">Style Inpsiration</a></li>
                                        <li><a href="member_reviews.html">My Reviews</a></li>
                                        <li><a href="member_upcoming.html">Upcoming Events</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container_main">
                    <h1 class="block_title">My Account</h1>
                    <div class="form_wrapper common_form account_form">
                        <a class="link_edit" href="<?= website_url('member/edit_account') ?>"><i class="icon_edit"></i>edit</a>
                        <div class="form_block">
                            <div class="controls_group">
                                <label>*Email</label>
                                <div class="controls">
                                    <input type="email" value="<?= $member->email ?>" readOnly>
                                </div>
                            </div>
                            <div class="controls_group">
                                <label>*Password</label>
                                <div class="controls">
                                    <input type="password" value="" readOnly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="block_title">My Profile</h1>
                    <div class="form_wrapper common_form account_form">
                        <a class="link_edit" href="<?= website_url('member/edit_profile') ?>"><i class="icon_edit"></i>edit</a>
                        <div class="form_block">
                            <div class="row">
                                <div class="grid">
                                    <div class="controls_group">
                                        <label>Photo</label>
                                        <div class="profile_picture">
                                            <div class="pic" style="background-image: url(<?= backend_url($member->memberImg) ?>)"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>First Name</label>
                                        <div class="controls">
                                            <input type="text" value="<?= $member->first_name ?>" readOnly>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>Last Name</label>
                                        <div class="controls">
                                            <input type="text" value="<?= $member->last_name ?>" readOnly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>Gender</label>
                                        <div class="controls">
                                            <div class="select_wrapper">
                                                <select disabled>
                                                    <option <?= $member->gender == 1 ? 'selected' : '' ?>>Woman</option>
                                                    <option <?= $member->gender == 0 ? 'selected' : '' ?>>Men</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>Age</label>
                                        <div class="controls">
                                            <div class="select_wrapper">
                                                <select disabled>
                                                    <?php for($i=0; $i<=150;$i++){ ?>
                                                        <option value="<?= $i ?>" <?= $i==$member->age ? 'selected' : '' ?>><?= $i ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
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
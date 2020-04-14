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
                    <h1 class="block_title">Edit Profile</h1>
                    <form class="form_wrapper common_form account_form" method="post">
                        <div class="form_block">
                            <div class="row">
                                <div class="grid">
                                    <div class="controls_group">
                                        <label>Photo</label>
                                        <div class="upload_photo">
                                            <div class="profile_picture">
                                                <div class="upload_pic pic" style="background-image: url(<?= backend_url($member->memberImg) ?>)">
                                                    <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                </div>
                                            </div>
                                            <a class="upload_btn btn common" href="javascript:;">Change</a>
                                            <input class="upload_input" type="file" accept=".png,.jpeg,.jpg,.gif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>First Name</label>
                                        <div class="controls">
                                            <input type="text" value="<?= $member->first_name ?>" name="first_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>Last Name</label>
                                        <div class="controls">
                                            <input type="text" value="<?= $member->last_name ?>" name="last_name" required>
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
                                                <select name="gender">
                                                    <option value="1" <?= $member->gender == 1 ? 'selected' : '' ?>>Woman</option>
                                                    <option value="0" <?= $member->gender == 0 ? 'selected' : '' ?>>Men</option>
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
                                                <select name="age">
                                                    <?php for($i=1;$i<150;$i++){ ?>
                                                        <option vilue="<?= $i ?>" <?= $i == $member->age ? 'selected' : ''?>><?= $i ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="call_action right"><a class="btn common" href="<?= website_url('member') ?>">Cancel</a>
                            <button class="btn confirm" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
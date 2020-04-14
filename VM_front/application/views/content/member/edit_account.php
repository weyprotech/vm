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
                    <h1 class="block_title">Edit Account</h1>
                    <form id="edit_account_form" class="form_wrapper common_form account_form" method="post">
                        <div class="form_block">
                            <div class="controls_group">
                                <label>*Email</label>
                                <div class="controls">
                                    <input type="email" value="<?= $member->email ?>" required>
                                </div>
                            </div>
                            <div class="controls_group">
                                <label>*Password</label>
                                <div class="controls">
                                    <input type="password" id="password" name="password" value="" required>
                                </div>
                            </div>
                            <div class="controls_group">
                                <label>*Confirmed Password</label>
                                <div class="controls">
                                    <input type="password" id="confirm_password" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="call_action right">
                            <a class="btn common" href="member_account.html">Cancel</a>
                            <button class="btn confirm" id="edit_account_save" type="button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
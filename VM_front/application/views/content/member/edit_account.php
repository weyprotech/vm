<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
            <div class="center_container container">
                <?= $this->load->view('content/member/_aside',array(),true) ?>
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
                            <a class="btn common" href="<?= website_url('member/member') ?>">Cancel</a>
                            <button class="btn confirm" id="edit_account_save" type="button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
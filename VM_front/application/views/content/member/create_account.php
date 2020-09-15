
<div class="popup_block popup_create">
  <div class="popup_inner">
    <div class="popup_create_form">
        <div class="create_form_inner">
            <h2 class="block_title">Join us</h2>
            <form class="form_wrapper" id="create_account_form">
                <div class="form_block">
                    <div class="controls_group">
                        <label>Account</label>
                        <div class="controls">
                            <input type="email" id="create_email" name="email" placeholder="Email"/>
                            <span style="display:none;">Email is already used</span>
                        </div>
                    </div>
                    <div class="controls_group">
                        <label>Password</label>
                        <div class="controls">
                            <input type="password" id="create_password" name="password" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="controls_group">
                        <label>Password Confirmed</label>
                        <div class="controls">
                            <input type="password" id="create_password_confirm" placeholder="Password"/>
                        </div>
                    </div>
                </div>
                <div class="call_action">
                    <button class="btn" id="create_account" type="button">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
    <div class="popup_create_picture">
      <div class="thumb">
        <div class="pic" style="background-image: url(<?= base_url('assets/images/img_popup_create.jpg') ?>)">
            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"/>
        </div>
      </div>
    </div>
  </div>
</div>


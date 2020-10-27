<main id="main">
    <div class="login_wrapper page_block">
        <div class="block_inner">
            <div class="login_container">
                <div class="login_block">
                    <h2 class="block_title">Member Login</h2>
                    <div class="login_form">
                        <div class="form_block">
                            <div class="controls_group">
                                <label>Account</label>
                                <div class="controls">
                                    <input type="email" placeholder="Email" id="email">
                                </div>
                            </div>
                            <div class="controls_group">
                                <label>Password</label>
                                <div class="controls">
                                    <input type="password" placeholder="Password" id="password">
                                </div>
                            </div>
                            <div class="remember_forgot">
                                <label class="check_wrapper">
                                    <input type="checkBox" id="remember" value=1><span>Remember Me</span>
                                </label>
                                <div class="divide_line"></div>
                                <a href="<?= website_url('forgot_password') ?>">Forgot Password</a>
                            </div>
                        </div>
                        <div class="call_action">
                            <button class="btn confirm" id="login" data-type="<?= $type ?>">Sign In</button>
                        </div>
                        <div class="create_link">Not a member? &nbsp; <a class="popup" href="<?= website_url('create_account') ?>">Create Account</a></div>
                    </div>
                </div>
                <div class="login_block">
                    <h2 class="block_title">Guest Login</h2>
                    <div class="other_login">
                        <!-- <div class="item"><a class="login_btn_guest" href="javascript:;">Continue as a guest</a></div> -->
                        <div class="item"><a class="login_btn_facebook" href="javascript:;"><i class="icon_login_facebook"></i>Continue with Facebook</a></div>
                        <div class="item"><a class="login_btn_google" href="javascript:;"><i class="icon_login_google"></i>Continue with Google</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
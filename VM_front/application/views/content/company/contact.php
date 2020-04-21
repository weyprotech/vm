<main id="main">
    <div class="page_banner">
        <img src="<?= base_url('assets/images/banner_company.jpg') ?>">
    </div>
    <div class="company_block page_block">
        <div class="block_inner">
            <h1 class="block_title">Contact Us</h1>
            <div class="block_main">
                <div class="words">
                    <p>Need some help? Check out our 
                    <a href="<?= website_url('help/faq') ?>">FAQ</a>
                     section, but if you can't find the answer you're looking for, please get in touch using one of the below options</p>
                </div>
                <div class="social_links">Connect with us:<a href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a><a href="javascript:;" target="_blank"><i class="icon_share_instagram"></i></a><a href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a><a href="javascript:;" target="_blank"><i class="icon_share_twitter"></i></a><a href="javascript:;" target="_blank"><i class="icon_share_youtube"></i></a><a href="javascript:;" target="_blank"><i class="icon_share_weibo"></i></a></div>
                <form class="form_wrapper common_form" method="post">
                    <div class="form_block">
                        <div class="controls_group">
                            <label>*Name</label>
                            <div class="controls">
                                <input type="text" name="name" required>
                            </div>
                        </div>
                        <div class="controls_group">
                            <label>*Email</label>
                            <div class="controls">
                                <input type="email" name="email" required>
                            </div>
                        </div>
                        <div class="controls_group">
                            <label>*Phone</label>
                            <div class="controls row phone_controls">
                                <div class="grid g_6_12">
                                    <div class="select_wrapper">
                                        <select name="phone_area_code" required>
                                            <?php if($area_numberList){
                                                foreach($area_numberList as $area_numberKey => $area_numberValue){ ?>
                                                    <option value="<?= $area_numberValue->number ?>"><?= $area_numberValue->area ?>(<?= $area_numberValue->number ?>)</option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid g_6_12">
                                    <input type="tel" name="phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="controls_group">
                            <label>*Contact me</label>
                            <div class="controls">
                                <label class="radio_wrapper">
                                    <input type="radio" name="contact_type" value="0" required><span>By Email</span>
                                </label>
                                <label class="radio_wrapper">
                                    <input type="radio" name="contact_type" value="1"><span>By Phone</span>
                                </label>
                            </div>
                        </div>
                        <div class="controls_group">
                            <label>*Choose your topic</label>
                            <div class="controls">
                                <div class="select_wrapper">
                                    <select name="topic" required>
                                        <?php if($topicList){
                                            foreach($topicList as $topicKey => $topicValue){ ?>
                                                <option value="<?= $topicValue->topic ?>"><?= $topicValue->topic ?></option>
                                            <?php } 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="controls_group">
                            <label>*Your comments</label>
                            <div class="controls">
                                <textarea name="comments" required></textarea>
                            </div>
                        </div>
                        <div class="captcha">
                            <div class="captcha_inner">
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <div id="re-captcha" class="g-recaptcha" data-sitekey="6Le8HewUAAAAADmQ5cRjdKsBA-pKDgtiMwzTKE3K"></div>
                            </div>
                        </div>
                    </div>
                    <div class="call_action right">
                        <button class="btn common" type="reset">Clear All</button>
                        <button class="btn confirm" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
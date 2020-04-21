<main id="main">
    <div class="help_center page_block">
        <div class="block_inner">
            <div class="center_container container">
                <div class="container_aside">
                    <div class="aside_block">
                        <div class="aside_menu fold_block">
                            <div class="fold">
                                <div class="fold_title">Help Center</div>
                                <div class="fold_content">
                                    <ul>
                                        <li><a href="<?= website_url('help/faq') ?>">FAQ</a></li>
                                        <li><a href="<?= website_url('help/delivery') ?>">Delivery</a></li>
                                        <li><a href="<?= website_url('help/exchange') ?>">Refunds &amp; Exchanges</a></li>
                                        <li><a href="<?= website_url('help/customer') ?>">Customer Service</a></li>
                                        <li><a class="current" href="<?= website_url('help/feedback') ?>">Feedback</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container_main">
                    <h1 class="block_title">Feedback</h1>
                    <div class="words">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut pretium pretium tempor. Ut eget imperdiet neque. In volutpat ante semper diam molestie, et aliquam erat laoreet.</p>
                    </div>
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
                                                    foreach($area_numberList as $area_numberKey => $area_numberValue) { ?>
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
                                        <input type="radio" name="contact_type" value="email" required><span>By Email</span>
                                    </label>
                                    <label class="radio_wrapper">
                                        <input type="radio" name="contact_type" value="phone"><span>By Phone</span>
                                    </label>
                                </div>
                            </div>
                            <div class="controls_group">
                                <label>*Choose your topic</label>
                                <div class="controls">
                                    <div class="select_wrapper">
                                        <select name="topic" required>
                                            <?php if($topicList){
                                                foreach($topicList as $topicKey => $topicValue){  ?>
                                                    <option value="<?= $topicValue->topic ?>"><?= $topicValue->topic ?></option>
                                                <?php } 
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="controls_group">
                                <label>*Your feedback</label>
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
    </div>
</main>
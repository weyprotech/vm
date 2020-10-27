<div class="popup_block">
    <div class="popup_inner popup_form popup_justForYou">
        <h2 class="block_title has_icon">
            <span><i class="icon_just_for_you"></i><?= langText('designer','just') ?></span>
        </h2>
        <div class="text">
            <?= langText('designer','just_content') ?>
        </div>
        <form class="form_wrapper" id="just_form" method="post">
            <input type="hidden" name="designerId" value="<?= $designerId ?>">
            <div class="form_block">
                <div class="controls_group">
                    <label><?= langText('designer','your_name') ?></label>
                    <div class="controls">
                        <input type="text" name="name" required/>
                    </div>
                </div>
                <div class="controls_group">
                    <label><?= langText('designer','contact_email') ?></label>
                    <div class="controls">
                        <input type="email" name="email" required/>
                    </div>
                </div>
                <div class="controls_group">
                    <label><?= langText('designer','a_made_to_order_function') ?></label>
                    <div class="controls">
                        <textarea placeholder="<?= langText('designer','just_placeholder') ?>" name="message" required></textarea>
                    </div>
                </div>
            </div>
            <div class="call_action">
                <button class="btn common" type="button" id="just_send"><?= langText('designer','send') ?></button>
            </div>
        </form>
    </div>
</div>
<div class="popup_block">
    <div class="popup_inner popup_form popup_message">
        <h2 class="block_title has_icon"><span><i class="icon_message"></i><?= langText('designer','message') ?></span></h2>
        <div class="text">
            <?= langText('designer','message_content') ?>
        </div>
        <form class="form_wrapper" id="message_form">
            <input type="hidden" name="designerId" value="<?= $designerId ?>">
            <div class="form_block">
                <div class="controls_group">
                    <label><?= langText('designer','your_name') ?></label>
                    <div class="controls">
                        <input type="text" name="name" required/>
                    </div>
                </div>
                <div class="controls_group">
                    <label><?= langText('designer','your_email') ?></label>
                    <div class="controls">
                        <input type="email" name="email" required/>
                    </div>
                </div>
                <div class="controls_group">
                    <label><?= langText('designer','your_message') ?></label>
                    <div class="controls">
                        <textarea placeholder="<?= langText('designer','message_placeholder') ?>" name="message"></textarea>
                    </div>
                </div>
            </div>
            <div class="call_action">
                <button class="btn common" type="button" id="message_send"><?= langText('designer','send') ?></button>
            </div>
        </form>
    </div>
</div>
<div class="popup_block">
  <div class="popup_inner popup_form popup_makeWish">
    <h2 class="block_title has_icon"><span><i class="icon_meteor_left"></i><?= langText('designer','make_a_wish') ?><i class="icon_meteor_right"></i></span></h2>
    <div class="text"><?= langText('designer','wish_content') ?></div>
    <form class="form_wrapper" id="wish_form" method="post" action="<?= website_url("designers/wish_popup/".$designerId) ?>">
      <input type="hidden" name="designerId" value="<?= $designerId ?>">
      <div class="form_block">
        <div class="controls_group">
          <label><?= langText('designer','subject') ?></label>
          <div class="controls">
            <input type="text" placeholder="<?= langText('designer','title') ?>" name="title" />
          </div>
        </div>
        <div class="controls_group">
          <label><?= langText('designer','your_wish') ?></label>
          <div class="controls">
            <textarea name="content" placeholder="<?= langText('designer','wish_content') ?>"></textarea>
          </div>
        </div>
      </div>
      <div class="call_action">
        <button class="btn common" type="button" id="wish_send"><?= langText('designer','send') ?></button>
      </div>
    </form>
  </div>
</div>
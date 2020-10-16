<div class="popup_block">
  <div class="popup_inner popup_form popup_gift">
    <h2 class="block_title has_icon"><span><i class="icon_gift_designer"></i>Gift designer</span></h2>
    <div class="text">Thank you for your rutrum quam vitae fringilla tt. Suspendisse nec tortor urna. Ut laoreet sodales nisi, quis iaculis nulla iaculis vitae. Donec sagittis faucibus lacus eget blandit.</div>
    <form class="form_wrapper" id="form" method="post" action="<?= website_url("designers/popup_gift/".$designerId) ?>">
      <div class="form_block">
        <div class="controls_group">
          <label>Gift amount</label>
          <div class="controls">
            <input name="money" type="text" placeholder="NT$"/>
          </div>
        </div>
        <div class="controls_group">
          <label>Choose your payment</label>
          <div class="controls row">
            <div class="grid g_6_12">
              <div class="btn_radio">
                <input id="payment1" type="radio" name="payway" value="0" checked="checked"/>
                <label for="payment1">Credit Card</label>
              </div>
            </div>
            <div class="grid g_6_12">
              <div class="btn_radio">
                <input id="payment2" type="radio" name="payway" value="2"/>
                <label for="payment2">Account deduction</label>
              </div>
            </div>
          </div>
        </div>
        <div class="controls_group">
          <label>Gift comments</label>
          <div class="controls">
            <textarea name="comment" placeholder="Leave us a message…"></textarea>
          </div>
        </div>
      </div>
      <div class="call_action">
        <button class="btn common" id="gift_send" type="button">Send</button>
        <button class="btn common popup_modal_dismiss" type="button" style="display:none;">Send</button>
        <!-- <button class="btn common popup_modal_dismiss" type="smbmit">Send</button> -->
      </div>
    </form>
  </div>
</div>
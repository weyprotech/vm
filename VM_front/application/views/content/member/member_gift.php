<main id="main">
  <div class="member_center page_block">
    <div class="block_inner">
      <div class="center_container container">
        <?= $this->load->view('content/member/_aside',array(),true) ?>
        <div class="container_main">
          <h1 class="block_title">Gift Designers</h1>
          <div class="words">
            <p>Vestibulum rutrum quam vitae fringilla tincidunt. Suspendisse nec tortor urna. Ut laoreet sodales nisi, quis iaculis nulla iaculis vitae. Donec sagittis faucibus lacus eget blandit. Mauris vitae ultricies metus, at con.</p>
          </div>
          <div class="rwd_table">
            <div class="thead">
              <div class="tr">
                <div class="th">Designer</div>
                <div class="th">Date</div>
                <div class="th">Comment</div>
                <div class="th">Payment</div>
                <div class="th">Amount</div>
              </div>
            </div>
            <div class="tbody">
              <?php if(!empty($giftList)){
                foreach($giftList as $giftKey => $giftValue){?>
                  <div class="tr">
                    <div class="td" data-label="Designer"><a class="designer_info" href="<?= website_url('designers/home').'?designerId='.$giftValue->designerId ?>">
                        <div class="profile_picture">
                          <div class="pic" style="background-image: url(<?= backend_url($giftValue->designImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                        </div>
                        <div class="di_name"><?= $giftValue->name ?></div></a></div>
                    <div class="td" data-label="Date"><?= $giftValue->date ?></div>
                    <div class="td" data-label="Comment">
                      <div class="limit_width"><span class="font_gray"><?= $giftValue->comment ?></span></div>
                    </div>
                    <?php switch($giftValue->payway){ 
                      case 0: ?>
                        <div class="td" data-label="Payment">Credit Card</div>
                      <?php break; 
                      case 1: ?>
                        <div class="td" data-label="Payment">ATM</div>
                      <?php break;
                      case 2: ?>
                        <div class="td" data-label="Payment">Point</div>
                      <?php break;
                    } ?>
                    <div class="td" data-label="Amount"><span class="font_khaki">NT$ <?= $giftValue->money ?></span></div>
                  </div>
                <?php }
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<div class="popup_block">
  <?php if(count($imgList) > 1){ ?>
    <!--↓ 若為單一影片，不顯示上下頁控制項 ↓-->
    <div class="popup_pager_controls"></div>
    <!--↑ 若為單一影片，不顯示上下頁控制項 ↑-->
  <?php } ?>
  <div class="popup_inner popup_media">
    <div class="popup_slider">
      <?php foreach ($imgList as $imgKey => $imgValue){?>
        <div class="slide">
          <?php if(empty($imgValue->youtube)){ ?>
            <img src="<?= backend_url($imgValue->big_thumbPath) ?>"/>
          <?php }else{ ?>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= youtube_id($imgValue->youtube) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="allowfullscreen"></iframe>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<div class="popup_block">
  <!--↓ 若為單一影片，不顯示上下頁控制項 ↓-->
  <div class="popup_pager_controls"></div>
  <!--↑ 若為單一影片，不顯示上下頁控制項 ↑-->
  <div class="popup_inner popup_media">
    <div class="popup_slider">
      <?php for($i=1;$i<=3;$i++){ 
        $youtube = 'popup'.($i).'youtube';
        $img = 'popup'.($i).'Img';?>
        <div class="slide">
          <?php if(empty($manufacture->$youtube)){ ?>
            <img src="<?= backend_url($manufacture->$img) ?>"/>
          <?php }else{ ?>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= youtube_id($manufacture->$youtube) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="allowfullscreen"></iframe>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<main id="main">
    <div class="ootd_list_wrapper page_block">
        <div class="block_inner wide">
            <h2 class="block_title">OOTD Inspirations</h2>
            <div class="block_main">
                <div class="ootd_list">
                    <div class="grid_sizer"></div>
                    <div class="gutter_sizer"></div>
                    <?php foreach($inspirationList as $inspirationKey => $inspirationValue){ ?>
                        <!--↓ 穿搭的list，先顯示15筆，頁面下滑時再撈資料，一次撈15筆 ↓-->
                        <div class="item">
                            <div class="item_inner">
                                <!--↓ 愛心加'active'，表示為有加入最愛 ↓-->
                                <?php if($this->session->userdata('memberinfo') && !empty($inspiration_likeList)){                                     
                                    foreach($inspiration_likeList as $inspiration_likeValue)?>
                                    <?php if($inspiration_likeValue->inspirationId == $inspirationValue->inspirationId){ ?>
                                        <a class="btn_favorite active" id="inspiration_like" data-ootdId="ootd01" href="javascript:;" onclick="click_like('<?= $inspirationValue->inspirationId ?>');"><i class="icon_favorite_heart"></i></a>
                                    <?php }else{ ?>
                                        <a class="btn_favorite" id="inspiration_like" data-ootdId="ootd01" href="javascript:;" onclick="click_like('<?= $inspirationValue->inspirationId ?>');"><i class="icon_favorite_heart"></i></a>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <a class="btn_favorite" id="inspiration_like" data-ootdId="ootd01" href="javascript:;" onclick="click_like('<?= $inspirationValue->inspirationId ?>');"><i class="icon_favorite_heart"></i></a>
                                <?php } ?>  
                                <!--↑ 愛心加'active'，表示為有加入最愛 ↑-->
                                <a href="<?= website_url('inspiration/detail?inspirationId=' . $inspirationValue->inspirationId) ?>">
                                    <div class="thumb">
                                        <img src="<?= backend_url($inspirationValue->inspirationImg) ?>">
                                    </div>
                                    <div class="text">
                                        <h3><?= $inspirationValue->title ?></h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--↑ 穿搭的list，先顯示15筆，頁面下滑時再撈資料，一次撈15筆 ↑-->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function click_like(inspirationId)
    {
        $.ajax({
            url:'<?= website_url('ajax/inspiration/set_like') ?>',
            type:'post',
            dataType:'json',
            data:{"inspirationId" : inspirationId},
            success: function(response){
                location.reload();
            }
        });
    }
</script>
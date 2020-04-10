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
                                <a class="btn_favorite" data-ootdId="ootd<?= $inspirationKey ?>" href="javascript:;">
                                    <i class="icon_favorite_heart"></i>
                                </a>
                                <!--↑ 愛心加'active'，表示為有加入最愛 ↑-->
                                <a href="ootd_detail.html">
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
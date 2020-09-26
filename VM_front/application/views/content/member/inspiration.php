<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
        <div class="center_container container">
            <?= $this->load->view('content/member/_aside',array(),true) ?>
            <div class="container_main">
                <h1 class="block_title">My Style Inspiration</h1>
                <div class="ootd_list_wrapper in_center">
                    <div class="ootd_list">
                        <div class="grid_sizer"></div>
                        <div class="gutter_sizer"></div>
                        <?php if(!empty($inspirationList)){
                            foreach($inspirationList as $inspirationKey => $inspirationValue){ ?>
                                <div class="item">
                                    <div class="item_inner">
                                        <!--↓ 愛心加'active'，表示為有加入最愛 ↓-->
                                        <a class="btn_favorite active" data-ootdId="ootd<?= $inspirationKey ?>" href="javascript:;">
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
                            <?php }
                        } ?>                        
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</main>
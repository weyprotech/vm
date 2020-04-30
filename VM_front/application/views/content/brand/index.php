<main id="main">
    <div class="filter_search_bar">
        <div class="bar_inner">
            <div class="filter_buttons">
                <a class="active" href="<?= website_url('brand/index') ?>">All</a>
                <a href="<?= website_url('brand/search').'?alphabet=A' ?>">A-Z</a>
            </div>
            <div class="search_form">
                <input type="search" placeholder="Designer / Brand name">
                <button type="button"><i class="icon_search"></i></button>
            </div>
        </div>
    </div>
    <div class="topping_block brand_topping">
        <div class="block_inner wide">
            <div class="topping_header">
                <div class="brand_topping_header">
                    <a class="header_content" href="<?= website_url('brand/story?brandId='.$top_brandList[0]->brandId) ?>">
                        <div class="thumb">
                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(<?= backend_url($top_brandList[0]->brandImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        <div class="intro">
                            <h3><?= $top_brandList[0]->name ?></h3>
                            <h4 class="designer_name">
                                <!--↓ 知名設計才會有鑽石icon ↓--><i class="icon_diamond_s"></i>
                                <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('assets/images/flag/'.$top_brandList[0]->country.'.png') ?>"><span><?= get_all_country($top_brandList[0]->country) ?></span>
                            </h4>
                        </div>
                    </a>
                </div>
            </div>
            <div class="topping_main">
                <div class="topping_list brand_topping_list scrollbar_y">
                <!--↓ 三篇 ↓-->
                <?php 
                if($top_brandList):
                    foreach ($top_brandList as $topKey => $topValue):
                        if($topKey != 0): ?>
                        <div class="item">
                            <a class="item_content" href="<?= website_url('brand/story?brandId='.$topValue->brandId) ?>">
                                <div class="thumb">
                                    <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                    <div class="pic" style="background-image: url(<?= backend_url($topValue->brandindexImg) ?>);">
                                        <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                    </div>
                                    <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                </div>
                                <div class="intro">
                                    <h3><?= $topValue->name ?></h3>
                                    <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($topValue->content, ENT_QUOTES, "UTF-8"))),"0","100","UTF-8") ?></p>
                                    <h4 class="designer_name">
                                        <?php if($topValue->grade == 1){ ?> 
                                            <!--↓ 知名設計才會有鑽石icon ↓--><i class="icon_diamond_s"></i>
                                        <?php } ?>
                                        <img class="flag" src="<?= base_url('assets/images/flag/'.$topValue->country.'.png') ?>"><span><?= $topValue->designer_name ?></span>
                                    </h4>
                                </div>
                            </a>
                        </div>
                        <?php endif;
                    endforeach;
                endif; ?>
                <!--↑ 三篇 ↑-->
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($italyList)){ ?>
        <div class="list_items_wrapper page_block bg_gray">
            <div class="block_inner wide">
                <h2 class="block_title">Fashion in Italy</h2>
                <div class="block_main">
                    <div class="list_items">
                        <?php foreach ($italyList as $italyKey => $italyValue){ ?>
                            <div class="item">
                                <a href="<?= website_url('brand/story?brandId='.$italyValue->brandId) ?>">
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($italyValue->brandindexImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                    </div>
                                    <p><?= $italyValue->name ?></p>
                                    <div class="designer_name">
                                        <?php if($topValue->grade == 1){ ?>
                                            <!--↓ 知名設計才會有鑽石icon ↓--><i class="icon_diamond_s"></i>
                                        <?php } ?>
                                        <img class="flag" src="<?= base_url('assets/images/flag/'.$italyValue->country.'.png') ?>"><span><?= $italyValue->designer_name ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($brandList)){ ?>
        <div class="list_items_wrapper page_block">
            <div class="block_inner wide">
                <h2 class="block_title">Explore world</h2>
                <div class="block_main">
                    <div class="list_items"  id="brand_explore">
                        <?php foreach($brandList as $brandKey => $brandValue){ ?>
                            <div class="item">
                                <a href="<?= website_url('brand/story?brandId='.$brandValue->brandId) ?>">
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($brandValue->brandindexImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                    </div>
                                    <p><?= $brandValue->name ?></p>
                                    <div class="designer_name">
                                        <?php if($brandValue->grade == 1){ ?>
                                            <!--↓ 知名設計才會有鑽石icon ↓--><i class="icon_diamond_s"></i>
                                        <?php } ?>
                                        <img class="flag" src="<?= base_url('assets/images/flag/'.$brandValue->country.'.png') ?>"><span><?= $brandValue->designer_name ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div><a class="btn common more" id="brand_more" data-start='14'>View More</a>
                </div>
            </div>
        </div>
    <?php } ?>
</main>
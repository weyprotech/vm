<main id="main">
    <div class="topping_block event_topping">
        <div class="block_inner">
            <div class="topping_header">
                <div class="event_topping_header">
                    <a class="header_content" href="<?= website_url('events/detail').'?eventId='.$top[0]->eventId ?>">
                        <div class="thumb">
                        <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                        <div class="pic" style="background-image: url(<?= backend_url($top[0]->eventImg) ?>);">
                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                        </div>
                        <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        <div class="intro">
                            <div class="date"><?= $top[0]->date ?></div>
                            <h3><?= $top[0]->title ?></h3>
                            <p><?= $top[0]->content ?></p>
                        </div>
                    </a>
                    <a class="btn common more" href="<?= website_url('events/detail').'?eventId='.$top[0]->eventId ?>">View More</a>
                </div>
            </div>
            <div class="topping_main">
                <div class="topping_list event_topping_list scrollbar_y">
                    <?php for($i = 1;$i <= 3;$i++){
                        if(isset($top[$i])){ ?>
                            <div class="item">
                                <a class="item_content" href="<?= website_url('events/detail').'?eventId='.$top[$i]->eventId ?>">
                                    <div class="thumb">
                                        <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                        <div class="pic" style="background-image: url(<?= backend_url($top[$i]->exploreImg) ?>)">
                                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                        </div>
                                        <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                    </div>
                                    <div class="intro">
                                        <div class="date"><?= $top[$i]->date ?></div>
                                        <h3><?= $top[$i]->title ?></h3>
                                        <p><?= $top[$i]->content ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <?php if($collections){ ?>
        <div class="list_slider_wrapper page_block designer_story">
            <div class="block_inner">
                <h2 class="block_title">New Collections</h2>
                <div class="block_main">
                    <div class="list_slider">
                        <?php foreach ($collections as $collectionKey => $collectionValue){ ?>
                            <div class="slide">
                                <a href="<?= website_url('events/detail').'?eventId='.$collectionValue->eventId ?>">
                                    <div class="date"><?= $collectionValue->date ?></div>
                                    <div class="thumb <?= !empty($collectionValue->collectionyoutube) ? 'is_video' : '' ?>">
                                        <div class="pic" style="background-image: url(<?= backend_url($collectionValue->collectionImg) ?>);">
                                            <img class="size" src="<?= base_url('assets/images/size_16x9.png') ?>">
                                        </div>
                                    </div>
                                    <h3 class="slide_title"><?= $collectionValue->title ?></h3>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if($explore){ ?>
        <div class="list_items_wrapper page_block">
            <div class="block_inner wide">
                <h2 class="block_title">Explore Events</h2>
                <div class="block_main">
                    <div class="list_items" id="explore_list">                    
                        <?php foreach($explore as $exploreKey => $exploreValue){ ?>
                            <div class="item">
                                <a href="<?= website_url('events/detail').'?eventId='.$exploreValue->eventId ?>">
                                    <div class="date"><?= $exploreValue->date ?></div>
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($exploreValue->exploreImg) ?>);">
                                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                        </div>
                                    </div>
                                    <h3 class="event_title"><?= $exploreValue->title ?></h3>
                                </a>
                            </div>
                        <?php } ?>
                    </div><a class="btn common more" id="event_more" data-count="14" data-notin="<?= $notin ?>" href="javascript:;">View More</a>
                </div>
            </div>    
        </div>
    <?php } ?>
</main>
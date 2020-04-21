<main id="main">
    <div class="search_block page_block">
        <div class="block_inner">
            <div class="title_sort">
                <h2 class="block_title">Search Results for ”<?= $search ?>”</h2>
                <div class="results_sort">
                    <div class="results_count"><?= $count ?> results</div>
                    <div class="dropdown_menu">
                        <div class="dropdown_head">Sort: Events</div>
                        <ul class="dropdown_list">
                        <li><a href="<?= website_url('search/index').'?search='.$search.'&type=product' ?>">Products</a></li>
                        <li><a class="current" href="javascript:;">Events</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="block_main">
                <div class="search_title">Events</div>
                <div class="search_main">
                    <div class="topping_list event_topping_list">
                        <?php if(!empty($result)){
                            foreach($result as $resultKey => $resultValue){ ?>
                                <div class="item">
                                    <a class="item_content" href="<?= website_url('events/detail').'?eventId='.$resultValue->eventId ?>">
                                        <div class="thumb">
                                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url($resultValue->exploreImg) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                            </div>
                                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </div>
                                        <div class="intro">
                                            <div class="date"><?= $resultValue->date ?></div>
                                            <h3><?= $resultValue->title ?></h3>
                                            <p><?= $resultValue->content ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                        } ?>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
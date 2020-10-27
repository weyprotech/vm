<main id="main">
    <div class="filter_search_bar">
        <div class="bar_inner">
            <div class="filter_buttons">
                <a class="active" href="<?= website_url('designers/index') ?>">All</a>
                <a href="<?= website_url('designers/search').'?alphabet=A' ?>">A-Z</a>
            </div>
            <form method="get" action="<?= website_url('designers/search') ?>">
                <div class="search_form">
                    <input type="search" name="search" placeholder="Designer name">
                    <button type="submit"><i class="icon_search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="topping_block designer_topping">
        <div class="block_inner">
            <div class="topping_header">
                <div class="designer_card">
                    <a class="btn_favorite <?= ($top_designerList[0]->like != false) ? 'active' : '' ?>" data-designerId="<?= $top_designerList[0]->designerId ?>" href="javascript:;"><i class="icon_favorite_heart"></i></a>
                    <a class="card_content" href="<?= website_url('designers/home').'?designerId='.$top_designerList[0]->designerId ?>">
                        <div class="thumb">
                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(<?= backend_url($top_designerList[0]->designImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        <div class="intro">
                        <div class="profile_picture">
                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(<?= backend_url($top_designerList[0]->designiconImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        <h3 class="designer_name">
                            <!--↓ 知名設計才會有鑽石icon ↓--><?= ($top_designerList[0]->grade == 1 ? '<i class="icon_diamond_s"></i>' : '') ?>
                            <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('assets/images/flag/'.$top_designerList[0]->country.'.png') ?>"><span><?= $top_designerList[0]->name ?></span>
                        </h3>
                        <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($top_designerList[0]->description, ENT_QUOTES, "UTF-8"))),"0","200","UTF-8") ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="topping_main">
                <div class="topping_list designer_topping_list scrollbar_y">
                    <?php 
                    if(!empty($top_designerList)){
                        foreach($top_designerList as $designerKey => $designerValue){ 
                            if($designerKey != 0){
                                if(isset($top_designerList[$designerKey])){ ?>
                                    <!--↓ 三篇 ↓-->
                                    <div class="item">
                                        <a class="btn_favorite <?= ($designerValue->like != false) ? 'active' : '' ?>" data-designerId="<?= $designerValue->designerId ?>" href="javascript:;"><i class="icon_favorite_heart"></i></a>
                                        <a class="item_content" href="<?= website_url('designers/home').'?designerId='.$designerValue->designerId ?>">
                                            <div class="thumb">
                                                <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                <div class="pic" style="background-image: url(<?= backend_url($designerValue->designImg) ?>);">
                                                    <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                </div>
                                                <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                            </div>
                                            <div class="intro">
                                                <div class="intro_inner">
                                                    <div class="profile_picture" href="designer_home.html">
                                                        <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                        <div class="pic" style="background-image: url(<?= backend_url($designerValue->designiconImg) ?>)">
                                                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                        </div>
                                                        <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                                    </div>
                                                    <h3 class="designer_name">
                                                        <!--↓ 知名設計才會有鑽石icon ↓--><?= ($designerValue->grade == 1 ? '<i class="icon_diamond_s"></i>' : '') ?>
                                                        <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('assets/images/flag/'.$designerValue->country.'.png') ?>"><span><?= $designerValue->name ?></span>
                                                    </h3>
                                                    <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($designerValue->description, ENT_QUOTES, "UTF-8"))),"0","200","UTF-8") ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php }
                            }
                        }
                    } ?>           
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($designer_story)){ ?>
        <div class="list_slider_wrapper page_block designer_story">
            <div class="block_inner">
                <h2 class="block_title"><?= langText('designer','designer_story') ?></h2>
                <div class="block_main">
                    <div class="list_slider">                        
                        <?php foreach($designer_story as $storyKey => $storyValue){ ?>
                            <div class="slide">
                                <a href="<?= website_url('designers/home').'?designerId='.$storyValue->designerId ?>">
                                    <div class="designer_name">
                                        <!--↓ 知名設計才會有鑽石icon ↓--><?= $storyValue->grade == 1 ? '<i class="icon_diamond"></i>' : '' ?>
                                        <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('assets/images/flag/'.$storyValue->country.'.png') ?>"><span><?= $storyValue->name ?></span>
                                    </div>
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($storyValue->designerstoryImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_16x9.png') ?>"></div>
                                    </div>
                                    <h3 class="slide_title"><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($storyValue->description, ENT_QUOTES, "UTF-8"))),"0","100","UTF-8") ?></h3>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <div class="list_items_wrapper page_block" id="explore_world">
        <div class="block_inner">
            <h2 class="block_title"><?= langText('designer','explore_world') ?></h2>
            <div class="block_main">
                <div class="list_items">
                    <?php if(!empty($designerList)){
                        foreach ($designerList as $designerKey => $designerValue){ ?>
                            <div class="item">
                                <a href="<?= website_url('designers/home').'?designerId='.$designerValue->designerId ?>">
                                    <h3 class="designer_name">
                                        <!--↓ 知名設計才會有鑽石icon ↓--><?= $designerValue->grade == 1 ? '<i class="icon_diamond_s"></i>' : '' ?>
                                        <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('assets/images/flag/'.$designerValue->country.'.png') ?>"><span><?= $designerValue->name ?></span>
                                    </h3>
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($designerValue->designImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                    </div>
                                    <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($designerValue->description, ENT_QUOTES, "UTF-8"))),"0","100","UTF-8") ?></p>
                                </a>
                            </div>
                        <?php }
                    } ?>
                </div>
                <div class="pager_bar">
                    <div class="pages"><?= langText('designer','page') ?> <?= $page ?> <?= langText('designer','of') ?> <?= $total_page ?></div>
                    <ul class="pager_navigation">
                        <li class="prev" style="margin-right:0px"><a href="<?= website_url('designers/index') ?><?= (($page != 1) ? '?page='.($page-1) : '?page='.$page ) ?>#explore_world">&lt;</a></li>
                        <li><a href="<?= website_url('designers/index').'?page='.((((floor($page/10)-1)*10)+1) < 1 ? 1 : (((floor($page/10)-1)*10)+1)) ?>#explore_world">...</a></li>
                        <?php for($i=($page % 10 == 0 ? $page-9 : (floor($page/10)*10)+1);$i<=($total_page > (ceil($page/10))*10 ? (ceil($page/10))*10 : $total_page);$i++){ ?>
                            <li <?= (($i == $page) ? 'class="current"' : '' )?>><a href="<?= website_url('designers/index').'?page='.$i ?>#explore_world"><?= $i ?></a></li>
                        <?php } ?>
                        <li><a href="<?= website_url('designers/index').'?page='.(((ceil($page/10))*10+1) < $total_page ? ((ceil($page/10))*10+1) : $total_page) ?>#explore_world">...</a></li>
                        <li class="next" style="margin-left:0;"><a href="<?= website_url('designers/index') ?><?= (($page != $total_page) ? '?page='.($page+1) : '?page='.$total_page ) ?>#explore_world">&gt;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
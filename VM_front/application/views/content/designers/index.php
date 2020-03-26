<main id="main">
    <div class="filter_search_bar">
        <div class="bar_inner">
            <div class="filter_buttons">
                <a class="active" href="designers.html">All</a>
                <a href="search_designers.html">A-Z</a>
            </div>
            <div class="search_form">
                <input type="search" placeholder="Designer name">
                <button type="button" onclick="location.href='search_designers.html'"><i class="icon_search"></i></button>
            </div>
        </div>
    </div>
    <div class="topping_block designer_topping">
        <div class="block_inner">
        <div class="topping_header">
            <div class="designer_card">
                <a class="btn_favorite" data-designerId="01" href="javascript:;"><i class="icon_favorite_heart"></i></a>
                <a class="card_content" href="designer_home.html">
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
                        <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('images/flag/'.$top_designerList[0]->country.'.png') ?>"><span><?= $top_designerList[0]->name ?></span>
                    </h3>
                    <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($top_designerList[0]->description, ENT_QUOTES, "UTF-8"))),"0","200","UTF-8") ?></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="topping_main">
            <div class="topping_list designer_topping_list scrollbar_y">
                <?php foreach($designerList as $designerKey => $designerValue){ 
                    if($designerKey != 0){?>
                    <!--↓ 三篇 ↓-->
                        <div class="item">
                            <a class="btn_favorite" data-designerId="02" href="javascript:;"><i class="icon_favorite_heart"></i></a>
                            <a class="item_content" href="designer_home.html">
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
                                            <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('images/flag/'.$designerValue->country.'.png') ?>"><span><?= $designerValue->name ?></span>
                                        </h3>
                                        <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($designerValue->description, ENT_QUOTES, "UTF-8"))),"0","200","UTF-8") ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php }
                } ?>           
            </div>
        </div>
        </div>
    </div>
    <div class="list_slider_wrapper page_block designer_story">
        <div class="block_inner">
            <h2 class="block_title">Designer Story</h2>
            <div class="block_main">
                <div class="list_slider">
                    <?php foreach($designer_story as $storyKey => $storyValue){ ?>
                        <div class="slide">
                            <a href="designer_home.html">
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
    <div class="list_items_wrapper page_block">
        <div class="block_inner">
            <h2 class="block_title">Explore world</h2>
            <div class="block_main">
                <div class="list_items">
                    <?php foreach ($designerList as $designerKey => $designerValue){ ?>
                        <div class="item">
                            <a href="designer_home.html">
                                <h3 class="designer_name">
                                    <!--↓ 知名設計才會有鑽石icon ↓--><?= $designerValue->grade == 1 ? '<i class="icon_diamond_s"></i>' : '' ?>
                                    <!--↑ 知名設計才會有鑽石icon ↑--><img class="flag" src="<?= base_url('assets/images/flag/'.$designerValue->country.'.png') ?>"><span><?= $designerValue->name ?></span>
                                </h3>
                                <div class="thumb">
                                    <div class="pic" style="background-image: url(<?= backend_url($designerValue->designerstoryImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                </div>
                                <p><?= mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($designerValue->description, ENT_QUOTES, "UTF-8"))),"0","100","UTF-8") ?></p>
                            </a>
                        </div>
                    <?php } ?>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                <div class="item"><a href="designer_home.html">
                    <h3 class="designer_name"><img class="flag" src="images/flag/IT.png"><span>Virginia Cox</span></h3>
                    <div class="thumb">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/360x480);"><img class="size" src="images/size_3x4.png"></div>
                    </div>
                    <p>Voici la coiffure que l’on verra partout à la rentrée</p></a></div>
                </div><a class="btn common more" href="javascript:;">More Designers</a>
            </div>
        </div>
    </div>
</main>
<main id="main">
    <div class="store_map_wrapper">
        <div class="store_map_main">
            <div id="storeMap"></div>
            <div id="mapSky">
                <img class="sky_day" src="<?= base_url('assets/images/leaflet/sky.png') ?>">
                <img class="sky_night" src="<?= base_url('assets/images/leaflet/sky_night.png') ?>">
            </div>
            <div class="radio_switch" id="mapMode">
                <input class="switch_off" id="day" type="radio" name="mapMode" checked>
                <input class="switch_on" id="night" type="radio" name="mapMode">
                <label class="switch_off_label" for="day"><span>Day mode</span></label>
                <label class="switch_on_label" for="night"><span>Night mode</span></label>
                <div class="turn_dot"></div>
            </div>
            <div class="isOpen" id="streetAside">
                <a class="open_aside" href="javascript:;"><i class="arrow_double_left"></i></a>
                <div class="aside_title">
                    <h2>Shopping map</h2>
                    <a class="close_aside" href="javascript:;"><i class="arrow_double_right"></i></a>
                </div>
                <div class="street_list"></div>
            </div>
        </div>
        <div id="streetStores">
            <div class="street_intro">
                <div class="intro_inner">
                    <h2></h2>
                    <hr>
                    <h3></h3>
                    <div class="text"></div>
                </div>
            </div>
            <div class="stores_slider"></div>
        </div>
    </div>
    <div class="top_designers page_block">
        <div class="block_inner">
            <h2 class="block_title">Top Designers</h2>
            <div class="block_main">
                <div class="top_designers_slider">
                    <?php foreach ($designerList as $designerKey => $designerValue){ ?>
                        <div class="slide">
                            <a class="slide_inner" href="<?= website_url('designers/home?designerId='.$designerValue->designerId) ?>">
                                <div class="thumb">
                                    <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                    <div class="pic" style="background-image: url(<?= backend_url($designerValue->designImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                    <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->                                    
                                </div>
                                <div class="designer_info">
                                    <div class="profile_picture">
                                        <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                        <div class="pic" style="background-image: url(<?= backend_url($designerValue->designiconImg) ?>);"><img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                        <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                    </div>
                                    <div class="text">
                                        <h3 class="designer_name">
                                            <!--↓ 知名設計才會有鑽石icon ↓--><i <?= $designerValue->grade == 1 ? 'class="icon_diamond_s"' : '' ?>></i>
                                            <!--↑ 知名設計才會有鑽石icon ↑--><span><?= $designerValue->name ?></span>
                                        </h3>
                                        <div class="country"><img class="flag" src="<?= base_url('assets/images/flag/'.$designerValue->country.'.png') ?>"><span><?= get_all_country($designerValue->country) ?></span></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div><a class="btn common more" href="<?= website_url('designers') ?>">All designers</a>
            </div>
        </div>
    </div>
    <div class="what_next page_block">
        <h2 class="block_title">What's Next</h2>
        <div class="what_next_main scrollbar_x">
            <div class="items">
                <?php foreach ($runwayList as $runwayKey => $runwayValue){ ?>
                    <div class="item">
                        <?php if($runwayValue->live == 1){ ?>
                            <div class="video_type">
                                <div class="dot red"></div>
                                <h3><?= $runwayValue->title ?></h3>
                                <div class="mark_live">Live</div>
                            </div>
                        <?php }else if($runwayValue->date.' '.$runwayValue->time > date('Y-m-d H:i:s')){ ?>
                            <div class="video_type">
                                <div class="dot yellow"></div>
                                <h3><?= $runwayValue->title ?></h3>
                                <!--↓ 如果是 youtube 的影片，class 要加 'video_youtube' ↓-->
                            </div>
                        <?php }else{ ?>
                            <div class="video_type">
                                <div class="dot green"></div>
                                <h3><?= $runwayValue->title ?></h3>
                                <!--↓ 如果是 youtube 的影片，class 要加 'video_youtube' ↓-->
                            </div>
                        <?php } ?>
                        <!--↓ 如果是 youtube 的影片，class 要加 'video_youtube' ↓-->
                        <div class="video video_youtube">
                            <?php if($runwayValue->live == 1){ ?>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= youtube_id($runwayValue->live_youtube) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <?php }else{
                                foreach($runwayValue->imgList as $imgKey => $imgValue){
                                    if(!empty($imgValue->youtube)){ ?>
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= youtube_id($imgValue->youtube) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <?php break;}
                                }
                            } ?>
                        </div>
                        <!--↑ 如果是 youtube 的影片，class 要加 'video_youtube' ↑-->
                    </div>
                <?php } ?>                
            </div>
        </div>
    </div>
    <div class="ads_banner">
        <?php if($homepageBanner){
            foreach ($homepageBanner as $bannerKey => $bannerValue){ ?>
                <div class="slide">
                    <div class="pic"><img src="<?= base_url('assets/images/img_ad_banner.jpg') ?>"></div>
                    <!--↓ 後台可設定網站五個顏色 ↓ -- bg_brown、bg_red、bg_purple、bg_blue、bg_green-->
                    <div class="text <?= $website_color->color ?>">
                        <div class="text_inner">
                            <div class="title"><?= $bannerValue->title ?></div>
                            <div class="subtitle"><?= $bannerValue->sub_title ?></div>
                            <p><?= $bannerValue->content ?></p><a class="btn common more" href="javascript:;">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
    <div class="ootd_list_wrapper page_block">
        <div class="block_inner wide">
            <h2 class="block_title">OOTD Inspirations</h2>
            <div class="block_main">
                <div class="ootd_list">
                    <div class="grid_sizer"></div>
                    <div class="gutter_sizer"></div>
                    <!--↓ 穿搭的list，15筆 ↓-->
                    <?php foreach($inspirationList as $inspirationKey => $inspirationValue){ ?>
                        <div class="item">
                            <div class="item_inner">
                                <!--↓ 愛心加'active'，表示為有加入最愛 ↓-->
                                <a class="btn_favorite active" data-ootdId="ootd<?= $inspirationKey ?>" href="javascript:;"><i class="icon_favorite_heart"></i></a>
                                <!--↑ 愛心加'active'，表示為有加入最愛 ↑-->
                                <a href="ootd_detail.html">
                                    <div class="thumb"><img src="<?= backend_url($inspirationValue->inspirationImg) ?>"></div>
                                    <div class="text">
                                        <h3><?= $inspirationValue->title ?></h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <!--↑ 穿搭的list，15筆 ↑-->
                </div><a class="btn common more" href="<?= website_url('inspiration/index') ?>">MORE</a>
            </div>
        </div>
    </div>
</main>

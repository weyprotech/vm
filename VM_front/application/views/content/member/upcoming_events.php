<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
            <div class="center_container container">
                <?= $this->load->view('content/member/_aside',array(),true) ?>                
                <div class="container_main">
                    <h1 class="block_title">Upcoming Events</h1>
                    <div class="rwd_table">
                        <div class="thead">
                            <div class="tr">
                                <div class="th">Designer</div>
                                <div class="th">Upcoming Event</div>
                            </div>
                        </div>
                        <div class="tbody">
                            <?php if(!empty($eventList)){
                                foreach($eventList as $eventKey => $eventValue){ ?>
                                    <div class="tr">
                                        <div class="td" data-label="Designer">
                                            <a class="designer_info" href="<?= website_url('designers/home').'?designerId='.$eventValue->designerId ?>">
                                                <div class="profile_picture">
                                                    <div class="pic" style="background-image: url(<?= backend_url($eventValue->designiconImg) ?>);">
                                                        <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                                    </div>
                                                </div>
                                                <div class="di_name"><?= $eventValue->name ?></div>
                                            </a>
                                        </div>
                                        <div class="td" data-label="Upcoming Event">
                                            <div class="event_info">
                                                <div class="date font_khaki"><?= $eventValue->date ?></div>
                                                <div class="text"><?= $eventValue->title ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                    <div class="pager_bar">
                        <div class="pages">Page 1 of <?= $totalPage ?></div>
                        <ul class="pager_navigation">
                            <li class="prev"><a href="javascript:;">&lt; Previous</a></li>
                            <?php for($i = 1;$i<$totalPage;$i++){ ?>
                                <li <?= $page == $i ? 'class="current"' : ''?>><a href="javascript:;"><?= $i ?></a></li>
                            <?php } ?>
                            <li class="next"><a href="javascript:;">Next &gt;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
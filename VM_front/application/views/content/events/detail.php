<main id="main">
    <div class="breadcrumbs">
        <div class="breadcrumbs_inner">
            <a href="<?= website_url('homepage') ?>">VM</a><span>/</span>
            <a href="<?= website_url('events') ?>">Events</a><span>/</span>
            <span class="current"><?= $row->title ?></span>
        </div>
    </div>
    <div class="detail_wrapper page_block">
        <div class="block_inner">
            <div class="container">
                <div class="container_main">
                    <div class="detail_article">
                        <h1 class="block_title"><?= $row->title ?></h1>
                        <div class="share_info">
                            <div class="share_links">Share:
                                <a class="facebook" href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a>
                                <a class="pinterest" href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a>
                                <a class="twitter" href="javascript:;" target="_blank"><i class="icon_share_twitter"></i></a>
                                <a class="weibo" href="javascript:;" target="_blank"><i class="icon_share_weibo"></i></a>
                            </div>
                            <div class="info">
                                <div class="date"><?= $row->date ?></div>
                            </div>
                        </div>
                        <div class="article_content fit_video">
                            <p><img src="<?= backend_url($row->eventImg) ?>"></p>
                            <?php if(!empty($row->collectionyoutube)){ ?>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= youtube_id($row->collectionyoutube) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="allowfullscreen"></iframe>                        
                            <?php } ?>
                            <?= nl2br($row->content) ?>                            
                        </div>
                    </div>
                </div>
                <div class="container_aside">
                    <div class="aside_block">
                        <h2 class="aside_title">Other Events</h2>
                        <div class="aside_other_events scrollbar_x">
                            <?php foreach ($eventList as $eventKey => $eventValue){ ?>
                                <div class="item">
                                    <a href="<?= website_url('events/detail').'?eventId='.$eventValue->eventId ?>">
                                        <div class="thumb">
                                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url($eventValue->eventImg) ?>);">
                                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>"></div>
                                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </div>
                                        <div class="text">
                                            <h3><?= $eventValue->title ?></h3>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
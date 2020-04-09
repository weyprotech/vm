<main id="main">
    <div class="filter_sort_bar">
        <div class="bar_inner">
            <div class="filter_selects">
                <!--篩選項目-->
            </div>
            <div class="results_sort">
                <div class="results_count"><?= $saleCount ?> items</div>
                <div class="dropdown_menu dropdown_select">
                    <div class="dropdown_head">Sort by: <span class="sortText"><?= $sort == 'popular' ? 'Popularity' : 'Price' ?></span></div>
                    <ul class="dropdown_list">
                        <li><a <?= $sort == 'price' ? 'class="current"' : '' ?> href="<?= website_url('sale/index').'?sort=price' ?>">Price</a></li>
                        <li><a <?= $sort == 'popular' ? 'class="current"' : '' ?> href="<?= website_url('sale/index').'?sort=popular' ?>">Popularity</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sale_wrapper page_block">
        <div class="block_inner">
            <div class="sale_banner">
                <!--↓ 後台可設定網站五個顏色，同.header_top ↓ -- bg_brown、bg_red、bg_purple、bg_blue、bg_green-->
                <div class="banner_content <?= $website_color->color ?>">
                    <div class="content_inner">
                        <div class="title"><?= $saleinformation->title ?></div>
                        <div class="subtitle"><?= $saleinformation->discount ?>% <small>off</small></div>
                        <hr>
                        <p><?= $saleinformation->content ?></p>
                    </div>
                </div>
                <!--↑ 後台可設定網站五個顏色，同.header_top ↑ -- bg_brown、bg_red、bg_purple、bg_blue、bg_green-->
                <div class="banner_pic">
                    <div class="thumb">
                        <div class="pic" style="background-image: url(<?= backend_url($saleinformation->informationImg) ?>)">
                            <img class="size" src="<?= base_url('assets/images/size_4x3.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="products_list span5">
                <?php if($saleList){            
                    foreach($saleList as $saleKey => $saleValue){ ?>
                    <div class="item">
                        <a href="<?= website_url('product/detail').'?productId='.$saleValue->pId ?>">
                            <div class="thumb">
                                <div class="pic" style="background-image: url(<?= backend_url($saleValue->productImg) ?>)">
                                    <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                </div>
                            </div>
                            <h3><?= $saleValue->name ?></h3>
                            <div class="price">
                                <span class="strikethrough">NT$ <?= $saleValue->original_price ?></span>
                                <span class="sale_price">NT$ <?= $saleValue->original_price-($saleValue->original_price*($saleinformation->discount/100)) ?></span>
                            </div>
                        </a>
                    </div>
                <?php }
                } ?>
            </div>
            <div class="pager_bar">
                <div class="pages">Page <?= $page ?> of <?= $total_page ?></div>
                <ul class="pager_navigation">
                    <li class="prev"><a href="<?= website_url('sale/index').'?page='.($page == 1 ? 1 : $page-1) ?>">&lt; Previous</a></li>
                    <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <li <?= $page == $i ? 'class="current"' : '' ?>><a href="<?= website_url('sale/index').'?page='.$i ?>"><?= $i ?></a></li>
                    <?php } ?>                    
                    <li class="next"><a href="<?= website_url('sale/index').'?page='.($page == $total_page ? $total_page : $page+1) ?>">Next &gt;</a></li>
                </ul>
            </div>
        </div>
    </div>
</main>
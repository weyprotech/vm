<main id="main">
    <div class="filter_sort_bar">
        <div class="bar_inner">
            <div class="filter_selects">
                <!--篩選項目-->
            </div>
            <div class="results_sort">
                <div class="results_count"><?= $product_count ?> items</div>
                <div class="dropdown_menu dropdown_select">
                    <div class="dropdown_head">Sort by: <span class="sortText"><?= $sort=='popular' ? 'Popularity' : 'Price'?></span></div>
                    <ul class="dropdown_list">
                        <li><a <?= $sort=='price' ? 'class="current"' : ''?> href="<?= website_url('product/brand_product').'?sort=price' ?><?= !empty($brandId) ? '&brandId='.$brandId : '' ?>">Price</a></li>
                        <li><a <?= $sort=='popular' ? 'class="current"' : ''?> href="<?= website_url('product/brand_product').'?sort=popular' ?><?= !empty($brandId) ? '&brandId='.$brandId : '' ?>">Popularity</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="products_show_wrapper page_block">
        <div class="block_inner">
            <div class="products_show">
                <div class="master_vision"><img src="<?= backend_url(@$category->categoryImg) ?>" alt=""></div>
                <div class="products_list span5">
                    <?php for($i=0;$i<4;$i++){
                        if(isset($productList[$i])){ ?>
                            <div class="item">
                                <a href="<?= website_url('product/detail').'?productId='.$productList[$i]->productId ?>">
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($productList[$i]->productImg) ?>)"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                    </div>
                                    <h3><?= $productList[$i]->name ?></h3>
                                    <?php if($productList[$i]->sale){ ?>
                                        <div class="price">
                                            <span class="strikethrough"><?= strtoupper($money_type) ?>$ <?= round($productList[$i]->price * $currency) ?></span>
                                            <span class="sale_price"><?= strtoupper($money_type) ?>$ <?= round((($productList[$i]->price)-($productList[$i]->price*($saleinformation->discount/100))) * $currency) ?></span>
                                        </div>                                    
                                    <?php }else{ ?>
                                        <div class="price"><?= strtoupper($money_type) ?>$ <?= round($productList[$i]->price * $currency) ?></div>
                                    <?php } ?>
                                </a>
                            </div>
                        <?php }
                    } ?>
                    <div class="item col_2">
                        <!--↓ 產品視覺圖 ↓-->
                        <div class="thumb">
                            <div class="pic" style="background-image: url(<?= backend_url(@$category->category2Img) ?>)"><img class="size" src="<?= base_url('assets/images/size_8x5.png') ?>"></div>
                        </div>
                        <!--↑ 產品視覺圖 ↑-->
                    </div>
                    <?php for($i=4;$i<15;$i++){
                        if(isset($productList[$i])){ ?>
                            <div class="item">
                                <a href="<?= website_url('product/detail').'?productId='.$productList[$i]->productId ?>">
                                    <div class="thumb">
                                        <div class="pic" style="background-image: url(<?= backend_url($productList[$i]->productImg) ?>)"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                    </div>
                                    <h3><?= $productList[$i]->name ?></h3>                                    
                                    <?php if($productList[$i]->sale){ ?>
                                        <div class="price">
                                            <span class="strikethrough"><?= strtoupper($money_type) ?>$ <?= round($productList[$i]->price * $currency) ?></span>
                                            <span class="sale_price"><?= strtoupper($money_type) ?>$ <?= round((($productList[$i]->price)-($productList[$i]->price*($saleinformation->discount/100))) * $currency) ?></span>
                                        </div>                                    
                                    <?php }else{ ?>
                                        <div class="price"><?= strtoupper($money_type) ?>$ <?= round($productList[$i]->price * $currency) ?></div>
                                    <?php } ?>
                                </a>
                            </div>
                        <?php }
                    } ?>
                    <div class="item col_2">
                        <!--↓ 產品視覺圖 ↓-->
                        <div class="thumb">
                            <div class="pic" style="background-image: url(<?= backend_url(@$category->category3Img) ?>)"><img class="size" src="<?= base_url('assets/images/size_8x5.png') ?>"></div>
                        </div>
                        <!--↑ 產品視覺圖 ↑-->
                    </div>
                    <?php for($i=15;$i<20;$i++){
                        if(isset($productList[$i])){ ?>
                        <div class="item">
                            <a href="<?= website_url('product/detail').'?productId='.$productList[$i]->productId ?>">
                                <div class="thumb">
                                    <div class="pic" style="background-image: url(<?= backend_url($productList[$i]->productImg) ?>)"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                </div>
                                <h3><?= $productList[$i]->name ?></h3>
                                <?php if($productList[$i]->sale){ ?>
                                    <div class="price">
                                        <span class="strikethrough"><?= strtoupper($money_type) ?>$ <?=round($productList[$i]->price * $currency) ?></span>
                                        <span class="sale_price"><?= strtoupper($money_type) ?>$ <?= round((($productList[$i]->price)-($productList[$i]->price*($saleinformation->discount/100)))*$currency) ?></span>
                                    </div>                                    
                                <?php }else{ ?>
                                    <div class="price"><?= strtoupper($money_type) ?>$ <?= round($productList[$i]->price * $currency) ?></div>
                                <?php } ?>
                            </a>
                        </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <div class="pager_bar">
                <div class="pages">Page <?= $page ?> of <?= $total_page ?></div>
                <ul class="pager_navigation">
                    <li class="prev"><a href="<?= website_url('product/brand_product') ?><?= (($page != 1) ? '?page='.($page-1) : '?page='.$page ) ?><?= !empty($sort) ? '&sort='.$sort : '' ?><?= !empty($brandId) ? '&brandId='.$brandId : '' ?>">&lt; Previous</a></li>
                    <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <li <?= (($i == $page) ? 'class="current"' : '' )?>><a href="<?= website_url('product/brand_product').'?page='.$i ?><?= !empty($brandId) ? '&brandId='.$brandId : '' ?>"><?= $i ?></a></li>
                    <?php } ?>
                    <li class="next"><a href="<?= website_url('product/brand_product') ?><?= (($page != $total_page) ? '?page='.($page+1) : '?page='.$total_page ) ?><?= !empty($sort) ? '&sort='.$sort : '' ?><?= !empty($brandId) ? '&brandId='.$brandId : '' ?>">Next &gt;</a></li>
                </ul>
            </div>
        </div>
    </div>
</main>
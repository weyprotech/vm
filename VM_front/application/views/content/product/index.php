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
                        <li><a <?= $sort=='price' ? 'class="current"' : ''?> href="<?= website_url('product/index').'?sort=price' ?><?= !empty($categoryId) ? '&categoryId='.$categoryId : '' ?><?= !empty($subId) ? '&subId='.$subId : '' ?><?= !empty($baseId) ? '&baseId='.$baseId : '' ?>">Price</a></li>
                        <li><a <?= $sort=='popular' ? 'class="current"' : ''?> href="<?= website_url('product/index').'?sort=popular' ?><?= !empty($categoryId) ? '&categoryId='.$categoryId : '' ?><?= !empty($subId) ? '&subId='.$subId : '' ?><?= !empty($baseId) ? '&baseId='.$baseId : '' ?>">Popularity</a></li>
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
                    <li class="prev" style="margin-right:0px"><a href="<?= website_url('product/index') ?><?= (($page != 1) ? '?page='.($page-1) : '?page='.$page ) ?><?= !empty($sort) ? '&sort='.$sort : '' ?><?= !empty($categoryId) ? '&categoryId='.$categoryId : '' ?><?= !empty($subId) ? '&subId='.$subId : '' ?><?= !empty($baseId) ? '&baseId='.$baseId : '' ?>">&lt;</a></li>
                    <li><a href="<?= website_url('product/index').'?page='.((((floor($page/10)-1)*10)+1) < 1 ? 1 : (((floor($page/10)-1)*10)+1)) ?><?= !empty($categoryId) ? '&categoryId='.$categoryId : '' ?><?= !empty($subId) ? '&subId='.$subId : '' ?><?= !empty($baseId) ? '&baseId='.$baseId : '' ?>">...</a></li>
                    <?php for($i=($page % 10 == 0 ? $page-9 : (floor($page/10)*10)+1);$i<=($total_page > (ceil($page/10))*10 ? (ceil($page/10))*10 : $total_page);$i++){ ?>
                        <li <?= (($i == $page) ? 'class="current"' : '' )?>><a href="<?= website_url('product/index').'?page='.$i ?><?= !empty($categoryId) ? '&categoryId='.$categoryId : '' ?><?= !empty($subId) ? '&subId='.$subId : '' ?><?= !empty($baseId) ? '&baseId='.$baseId : '' ?>"><?= $i ?></a></li>
                    <?php } ?>
                    <li><a href="<?= website_url('product/index').'?page='.(((ceil($page/10))*10+1) < $total_page ? ((ceil($page/10))*10+1) : $total_page) ?><?= !empty($categoryId) ? '&categoryId='.$categoryId : '' ?><?= !empty($subId) ? '&subId='.$subId : '' ?><?= !empty($baseId) ? '&baseId='.$baseId : '' ?>">...</a></li>
                    <li class="next" style="margin-left:0;"><a href="<?= website_url('product/index') ?><?= (($page != $total_page) ? '?page='.($page+1) : '?page='.$total_page ) ?><?= !empty($sort) ? '&sort='.$sort : '' ?><?= !empty($categoryId) ? '&categoryId='.$categoryId : '' ?><?= !empty($subId) ? '&subId='.$subId : '' ?><?= !empty($baseId) ? '&baseId='.$baseId : '' ?>">&gt;</a></li>
                </ul>
            </div>
        </div>
    </div>
</main>
<main id="main">
    <?= $link ?>
    <div class="designer_brands_sort page_block">
        <div class="block_inner">
            <h2 class="block_title">My Brands</h2>
            <div class="block_main">
                <div class="brands_sort">
                    <?php if($brandList){
                        foreach($brandList as $brandKey => $brandValue){ ?>
                            <div class="item">
                                <a <?= $brandValue->brandId == $brandId ? 'class="current"' : '' ?> href="<?= website_url('designers/product').'?designerId='.$row->designerId.'&brandId='.$brandValue->brandId ?>">
                                    <div class="brand_logo">
                                        <div class="pic" style="background-image: url(<?= backend_url($brandValue->brandiconImg) ?>);">
                                            <img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">
                                        </div>
                                    </div>
                                    <h3><?= $brandValue->name ?></h3>
                                </a>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($brandId) && $category){ ?>
        <div class="designer_new_arrivals page_block">
            <div class="block_inner">
                <h2 class="block_title">New Arrivals</h2>
                <div class="block_main">
                    <div class="news_arrivals scrollbar_x">
                        <div class="news_arrivals_inner">
                            <div class="products_list">
                                <?php for($i=0;$i<2;$i++){
                                    if(isset($productList[$i])){ ?>
                                        <div class="item">
                                            <a href="<?= website_url('product/detail').'?productId='.$productList[$i]->productId ?>">
                                                <div class="thumb">
                                                    <div class="pic" style="background-image: url(<?= backend_url($productList[$i]->productImg) ?>)">
                                                        <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                    </div>
                                                </div>
                                                <h3><?= $productList[$i]->name ?></h3>                                            
                                                <?php if($productList[$i]->sale){ ?>
                                                    <div class="price">
                                                        <span class="strikethrough"><?= strtoupper($money_type) ?>$ <?= round($productList[$i]->price * $currency)?></span>
                                                        <span class="sale_price"><?= strtoupper($money_type) ?>$ <?= round((($productList[$i]->price)-($productList[$i]->price*($saleinformation->discount/100))) * $currency) ?></span>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="price"><?= strtoupper($money_type) ?>$ <?= round($productList[$i]->price * $currency) ?></div>
                                                <?php } ?>
                                            </a>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                            <div class="master_vision"><img src="<?= backend_url($category->categoryImg) ?>"></div>
                            <div class="products_list">
                                <?php for($i=2;$i<4;$i++){ 
                                    if(isset($productList[$i])){ ?>
                                        <div class="item">
                                            <a href="<?= website_url('product/detail').'?productId='.$productList[$i]->productId ?>">
                                                <div class="thumb">
                                                    <div class="pic" style="background-image: url(<?= backend_url($productList[$i]->productImg) ?>)">
                                                        <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                    </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($brandId) && $category){ ?>
        <div class="designer_products page_block">
            <div class="block_inner">
                <h2 class="block_title">Products</h2>
                <div class="block_main">
                    <div class="sort_menu">
                        <ul>
                            <?php if($categoryList){
                                foreach($categoryList as $categoryKey => $categoryValue){ ?>
                                    <li><a <?= $categoryValue->categoryId == $category->categoryId ? 'class="current"' : '' ?> href="<?= website_url('designers/product').'?designerId='.$designerId.'&brandId='.$brandId.'&categoryId='.$categoryValue->categoryId ?>"><?= $categoryValue->name ?></a></li>
                                <?php }
                            } ?>                    
                        </ul>
                    </div>
                    <div class="products_list span5">
                        <div class="item col_2">
                            <!--↓ 產品主標題 ↓-->
                            <div class="product_list_head">
                                <!--↓ 產品視覺圖 ↓-->
                                <div class="thumb">
                                    <div class="pic" style="background-image: url(<?= backend_url($category->category2Img) ?>)">
                                    <img class="size" src="<?= base_url('assets/images/size_8x5.png') ?>"></div>
                                </div>
                                <!--↑ 產品視覺圖 ↑-->
                                <!-- <div class="text">
                                    <h2>HERITAGE TRENCH COATS</h2>
                                    <p>Cras quis nulla commodo, aliquam lectus sed bland augue. Cras ullamcorper bibendum bibendum. Duis tincidunt urna non pretium porta. </p>
                                </div> -->
                            </div>
                            <!--↑ 產品主標題 ↑-->
                        </div>
                        <?php if($productList){
                            for($i=0;$i<9;$i++){ 
                                if(isset($productList[$i])){?>
                                    <div class="item">
                                        <a href="<?= website_url('product/detail').'?productId='.$productList[$i]->productId ?>">
                                            <div class="thumb">
                                                <div class="pic" style="background-image: url(<?= backend_url($productList[$i]->productImg) ?>)">
                                                    <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                </div>
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
                            }
                        } ?>
                        <div class="item col_2">
                            <!--↓ 產品視覺圖 ↓-->
                            <div class="thumb">
                                <div class="pic" style="background-image: url(<?= backend_url($category->category3Img) ?>)">
                                    <img class="size" src="<?= base_url('assets/images/size_8x5.png') ?>">
                                </div>
                            </div>
                            <!--↑ 產品視覺圖 ↑-->
                        </div>
                        <?php if($productList){
                            for($i=9;$i<15;$i++){
                                if(isset($productList[$i])){ ?>
                                    <div class="item">
                                        <a href="<?= website_url('product/detail').'?productId='.$productList[$i] ?>">
                                            <div class="thumb">
                                                <div class="pic" style="background-image: url(<?= backend_url($productList[$i]->productImg) ?>)">
                                                    <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                </div>
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
                            }
                        } ?>                                
                    </div>
                    <a class="btn common more" href="javascript:;">More Products</a>
                </div>
            </div>
        </div>
    <?php } ?>    
</main>
<main id="main">
    <div class="search_block page_block">
        <div class="block_inner">
            <div class="title_sort">
                <h2 class="block_title">Search Results for ”<?= $search ?>”</h2>
                <div class="results_sort">
                <div class="results_count"><?= $count ?> results</div>
                <div class="dropdown_menu">
                    <div class="dropdown_head">Sort: Products</div>
                    <ul class="dropdown_list">
                    <li><a class="current" href="javascript:;">Products</a></li>
                    <li><a href="<?= website_url('search/index').'?search='.$search.'&type=events' ?>">Events</a></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="block_main">
                <div class="search_title">Products</div>
                <div class="search_main">
                    <div class="products_list span5">
                        <?php if($result){
                            foreach($result as $resultKey => $resulttValue){ ?>
                                <div class="item">
                                    <a href="<?= website_url('product/detail').'?productId='.$resulttValue->productId ?>">
                                        <div class="thumb">
                                            <div class="pic" style="background-image: url(<?= backend_url($resulttValue->productImg) ?>)"><img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>"></div>
                                        </div>
                                        <h3><?= $resulttValue->name ?></h3>
                                        <?php if($resulttValue->sale){ ?>
                                            <div class="price">
                                                <span class="strikethrough">NT$ <?= $resulttValue->price ?></span>
                                                <span class="sale_price">NT$ <?= (($resulttValue->price)-($resulttValue->price*($saleinformation->discount/100))) ?></span>
                                            </div>                                    
                                        <?php }else{ ?>
                                            <div class="price">NT$ <?= $resulttValue->price ?></div>
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
</main>
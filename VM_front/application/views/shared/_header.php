<header id="header">
    <div class="header_main">
        <div class="header_main_inner">
            <a id="btn_menu" href="javascript:;"><span></span></a>
            <div class="header_search">
                <form class="form-control" method="get" action="<?= website_url('search/index') ?>">
                    <div class="search_form">
                        <input type="search" name="search" value="<?= $this->input->get('search') ?>" placeholder="What are you looking for?">
                        <input type="hidden" name="type" value="product">
                        <button type="submit"><i class="icon_search"></i></button>
                    </div>
                </form>
            </div>
            <a class="header_logo" href="<?= website_url('homepage') ?>">
                <img class="retina" src="<?= base_url('assets/images/logo.png') ?>">
            </a>
            <div class="user_options">
                <div class="option_search">
                    <a href="javascript:;"><i class="icon_search"></i></a>
                </div>
                <!--↓ 上線時，class加'online'，並且連結至'member_account.html'; 未上線時，連結至'login.html' ↓-->
                <div class="option_member <?=(isset($this->session->userdata('memberinfo')['memberId']))?"onlin":""?>">
                    <a href="<?= website_url('login') ?>"><i class="icon_member"></i></a>
                </div>
                <!--↑ 上線時，class加'online'，並且連結至'member_account.html'; 未上線時，連結至'login.html' ↑-->
                <!--↓ 有產品在購物車時時，class加'have' ↓-->
                <div class="option_cart <?= (!empty($cart_productList) ? 'have' : '') ?>">
                    <a class="cart_toggle" href="javascript:;"><i class="icon_cart"></i></a>
                    <div class="cart_drop">
                        <div class="cart_view scrollbar_y">
                            <div class="title"><?= $cart_amount ?> Items</div>
                            <div class="cart_items">
                                <?php if(!empty($cart_productList)){
                                    foreach($cart_productList as $cartKey => $cartValue){ ?>
                                        <div class="item">
                                            <a class="btn_delete" href="javascript:;" data-productid=<?= $cartValue['productId'] ?>><i class="icon_delete"></i></a>
                                            <a class="thumb" href="<?= website_url('product/detail').'?productId='.$cartValue['productId'] ?>">
                                                <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                                <div class="pic" style="background-image: url(<?= backend_url($cartValue['productImg']) ?>);">
                                                    <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                                </div>
                                                <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                            </a>
                                            <div class="content">
                                                <div class="price">$ <?= $cartValue['productPrice'] ?></div>
                                                <ul>
                                                    <li>size: <?= $cartValue['productSize'] ?></li>
                                                    <li>color: <?= $cartValue['productColor'] ?></li>
                                                    <li>Qty: <?= $cartValue['productQty'] ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                            <div class="cart_foot">
                                <div class="total_calculation">
                                    <div class="label">Subtotal</div>
                                    <div class="total_amount">NTD $<?= $cart_total ?></div>
                                </div>
                                <a class="btn confirm" href="order.html">CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--↑ 有產品在購物車時時，class加'have' ↑-->
                <?php if(isset($this->session->userdata('memberinfo')['memberId'])){ ?>
                    <div class="option_logout">
                        <a href="<?= website_url('logout') ?>"><i class="icon_logout"></i></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="header_nav_wrap">
        <nav class="header_nav">
            <ul>
                <li><a class="<?= ((stripos($_SERVER['REQUEST_URI'],'brand') && !stripos($_SERVER['REQUEST_URI'],'designers'))? 'current active' : '') ?>" href="<?= website_url('brand') ?>"><?=langText('header', 'brands') ?></a></li>
                <li><a class="<?= ((stripos($_SERVER['REQUEST_URI'],'designers') && !stripos($_SERVER['REQUEST_URI'],'popular_designers')) ? 'current active' : '') ?>" href="<?= website_url('designers') ?>"><?=langText('header', 'designers') ?></a></li>
                <?php foreach($categoryList as $firstKey => $firstValue){ ?>
                    <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],$firstValue->categoryId) ? 'current active' : (($product->baseId == $firstValue->categoryId) ? 'current active' :(($category['menu_basecategory'] == $firstValue->categoryId) ? 'current active' : ''))) ?>" href="<?= website_url('product/index?baseId='.$firstValue->categoryId) ?>"><?= $firstValue->name ?></a>
                        <div class="sub_menu">
                            <ul>
                                <?php if(!empty($categoryList[$firstKey]->categoryList)){ ?>
                                    <?php foreach($categoryList[$firstKey]->categoryList as $subKey => $subValue){ ?>
                                        <li>
                                            <a class="<?= (stripos($_SERVER['REQUEST_URI'],$subValue->categoryId) ? 'current active' : (($product->subId == $subValue->categoryId) ? 'current active' : (($category['menu_subcategory'] == $subValue->categoryId) ? 'current active' : ''))) ?>" href="<?= website_url('product/index?subId='.$subValue->categoryId) ?>"><?= $subValue->name ?></a>
                                            <ul>
                                                <?php if(!empty($categoryList[$firstKey]->categoryList[$subKey]->categoryList)){ ?>
                                                    <?php foreach($categoryList[$firstKey]->categoryList[$subKey]->categoryList as $categoryKey => $categoryValue){ ?>
                                                        <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],$categoryValue->categoryId) ? 'current active' : (($product->cId == $categoryValue->categoryId) ? 'current active' : ($category['menu_category'] == $categoryValue->categoryId) ? 'current active' : '')) ?>" href="<?= website_url('product/index?categoryId='.$categoryValue->categoryId) ?>"><?= $categoryValue->name ?></a></li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php } ?>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'sale') ? 'current active' : '') ?>" href="<?= website_url('sale') ?>"><?=langText('header', 'sale') ?></a></li>
                <li><a class="<?= ((stripos($_SERVER['REQUEST_URI'],'events')) && (!stripos($_SERVER['REQUEST_URI'],'type=events')) ? 'current active' : '') ?>" href="<?= website_url('events') ?>"><?=langText('header', 'events') ?></a></li>
                <li><a class="<?= (stripos($_SERVER['REQUEST_URI'],'popular_designers') ? 'current active' : '') ?>" href="<?= website_url('popular_designers') ?>"><?=langText('header', 'popular_designers') ?></a></li>
            </ul>
        </nav>
    </div>
</header>
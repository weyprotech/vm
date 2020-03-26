<header id="header">
    <div class="header_main">
        <div class="header_main_inner">
            <a id="btn_menu" href="javascript:;"><span></span></a>
            <div class="header_search">
                <div class="search_form">
                    <input type="search" placeholder="What are you looking for?">
                    <button type="button" onclick="location.href='search_products.html'"><i class="icon_search"></i></button>
                </div>
            </div>
            <a class="header_logo" href="index.html">
                <img class="retina" src="<?= base_url('assets/images/logo.png') ?>">
            </a>
            <div class="user_options">
                <div class="option_search">
                    <a href="javascript:;"><i class="icon_search"></i></a>
                </div>
                <!--↓ 上線時，class加'online'，並且連結至'member_account.html'; 未上線時，連結至'login.html' ↓-->
                <div class="option_member">
                    <a href="login.html"><i class="icon_member"></i></a>
                </div>
                <!--↑ 上線時，class加'online'，並且連結至'member_account.html'; 未上線時，連結至'login.html' ↑-->
                <!--↓ 有產品在購物車時時，class加'have' ↓-->
                <div class="option_cart have">
                    <a class="cart_toggle" href="javascript:;"><i class="icon_cart"></i></a>
                    <div class="cart_drop">
                        <div class="cart_view scrollbar_y">
                            <div class="title">2 Items</div>
                            <div class="cart_items">
                                <div class="item">
                                    <a class="btn_delete" href="javascript:;"><i class="icon_delete"></i></a>
                                    <a class="thumb" href="product_detail.html">
                                        <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                        <div class="pic" style="background-image: url(images/img_product01.jpg);">
                                            <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                        </div>
                                        <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                    </a>
                                    <div class="content">
                                        <div class="price">$ 1148</div>
                                        <ul>
                                            <li>size: M</li>
                                            <li>color: dot</li>
                                            <li>Qty: 1</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="item">
                                    <a class="btn_delete" href="javascript:;"><i class="icon_delete"></i></a>
                                    <a class="thumb" href="product_detail.html">
                                        <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                        <div class="pic" style="background-image: url(https://via.placeholder.com/300x400);">
                                            <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                        </div>
                                        <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                    </a>
                                    <div class="content">
                                        <div class="price">$ 1148</div>
                                        <ul>
                                            <li>size: M</li>
                                            <li>color: dot</li>
                                            <li>Qty: 1</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <div class="cart_foot">
                            <div class="total_calculation">
                                <div class="label">Subtotal</div>
                                <div class="total_amount">NTD $2,296</div>
                            </div>
                            <a class="btn confirm" href="order.html">CHECKOUT</a>
                        </div>
                        </div>
                    </div>
                </div>
                <!--↑ 有產品在購物車時時，class加'have' ↑-->
                <!--↓ 登入後顯示，按下即登出 ↓-->
                <div class="option_logout">
                    <a href="javascript:;"><i class="icon_logout"></i></a>
                </div>
                <!--↑ 登入後顯示，按下即登出 ↑-->
            </div>
        </div>
    </div>
    <div class="header_nav_wrap">
        <nav class="header_nav">
            <ul>
                <li><a href="designers.html">Designers</a></li>
                <li><a href="brands.html">Brands</a></li>
                <li><a href="products.html">Women</a>
                <div class="sub_menu">
                    <ul>
                        <li><a href="products.html">CLOTHING</a>
                            <ul>
                                <li><a href="products.html">Jeaens</a></li>
                                <li><a href="products.html">Trench Coats</a></li>
                                <li><a href="products.html">Jackets</a></li>
                                <li><a href="products.html">Coats</a></li>
                                <li><a href="products.html">Quilts &amp; Puffers</a></li>
                                <li><a href="products.html">Suits</a></li>
                                <li><a href="products.html">Blazers</a></li>
                                <li><a href="products.html">Formal Shirts</a></li>
                            </ul>
                        </li>
                        <li><a href="products.html">BAGS</a>
                            <ul>
                                <li><a href="products.html">Bags</a></li>
                                <li><a href="products.html">Scarves</a></li>
                                <li><a href="products.html">Wallets &amp; Card Cases</a></li>
                                <li><a href="products.html">Travel Accessories</a></li>
                                <li><a href="products.html">Ties &amp; Cunfflinks</a></li>
                                <li><a href="products.html">Key Rings</a></li>
                                <li><a href="products.html">Hats &amp; Gloves</a></li>
                            </ul>
                        </li>
                        <li><a href="products.html">ACCESSORIES</a>
                            <ul>
                                <li><a href="products.html">Scarves</a></li>
                                <li><a href="products.html">Wallets &amp; Card Cases</a></li>
                                <li><a href="products.html">Key &amp; Bag Charms</a></li>
                                <li><a href="products.html">Travel Accessories</a></li>
                                <li><a href="products.html">Belts</a></li>
                                <li><a href="products.html">Jewellery</a></li>
                                <li><a href="products.html">Hats &amp; Gloves</a></li>
                                <li><a href="products.html">Eyewear</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                </li>
                <li><a href="products.html">Men</a>
                <div class="sub_menu">
                    <ul>
                        <li><a href="products.html">CLOTHING</a>
                            <ul>
                                <li><a href="products.html">Jeaens</a></li>
                                <li><a href="products.html">Trench Coats</a></li>
                                <li><a href="products.html">Jackets</a></li>
                                <li><a href="products.html">Coats</a></li>
                                <li><a href="products.html">Quilts &amp; Puffers</a></li>
                                <li><a href="products.html">Suits</a></li>
                                <li><a href="products.html">Blazers</a></li>
                                <li><a href="products.html">Formal Shirts</a></li>
                            </ul>
                        </li>
                        <li><a href="products.html">BAGS</a>
                            <ul>
                                <li><a href="products.html">Bags</a></li>
                                <li><a href="products.html">Scarves</a></li>
                                <li><a href="products.html">Wallets &amp; Card Cases</a></li>
                                <li><a href="products.html">Travel Accessories</a></li>
                                <li><a href="products.html">Ties &amp; Cunfflinks</a></li>
                                <li><a href="products.html">Key Rings</a></li>
                                <li><a href="products.html">Hats &amp; Gloves</a></li>
                            </ul>
                        </li>
                        <li><a href="products.html">ACCESSORIES</a>
                            <ul>
                                <li><a href="products.html">Scarves</a></li>
                                <li><a href="products.html">Wallets &amp; Card Cases</a></li>
                                <li><a href="products.html">Key &amp; Bag Charms</a></li>
                                <li><a href="products.html">Travel Accessories</a></li>
                                <li><a href="products.html">Belts</a></li>
                                <li><a href="products.html">Jewellery</a></li>
                                <li><a href="products.html">Hats &amp; Gloves</a></li>
                                <li><a href="products.html">Eyewear</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                </li>
                <li><a href="sale.html">Sale</a></li>
                <li><a href="events.html">Events</a></li>
                <li><a href="popular_designers.html">Popular Designers</a></li>
            </ul>
        </nav>
    </div>
</header>
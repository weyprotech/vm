<main id="main">
    <div class="shopping_cart page_block">
        <div class="block_inner">
            <h1 class="block_subtitle">Shopping Cart</h1>
            <div class="block_main">
                <form>
                    <div class="checkout_cart">
                        <div class="cart_title">
                            <div class="main">Product</div>
                            <div class="label_size">Size</div>
                            <div class="label_color">Color</div>
                            <div class="label_quantity">Quantity</div>
                            <div class="label_price">Price</div>
                        </div>
                        <div class="cart_container">
                            <ul class="cart_items">
                                <?php foreach($cart_productList as $productKey => $productValue){ ?>
                                    <li class="item" id="item_<?= $productValue['productId'] ?>">
                                        <a class="thumb" href="<?= website_url('product/detail').'?productId='.$productValue['productId'] ?>">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url($productValue['productImg']) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                            </div>
                                        </a>
                                        <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑--></a>
                                        <div class="content">
                                            <div class="ci_info">
                                                <div class="ci_name"><?= $productValue['productName'] ?></div>
                                                <div class="ci_description"><?= $productValue['productIntroduction'] ?></div>
                                            </div>
                                            <div class="ci_size">
                                                <div class="select_wrapper">
                                                    <select id="size_<?= $productValue['productId'] ?>" onchange="website.change_cart('<?= $productValue['productId'] ?>')">
                                                        <?php foreach($productValue['sizeList'] as $cartKey => $cartValue){ ?>
                                                            <option <?= $cartValue->size == $productValue['productSize'] ? 'selected' : '' ?>><?= $cartValue->size ?></option>
                                                        <?php } ?>                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="ci_color">
                                                <div class="select_wrapper">
                                                    <select id="color_<?= $productValue['productId'] ?>" onchange="website.change_cart('<?= $productValue['productId'] ?>')">
                                                        <?php foreach($productValue['colorList'] as $colorKey => $colorValue){ ?>
                                                            <option <?= $colorValue->color == $productValue['productColor'] ? 'selected' : '' ?>><?= $colorValue->color ?></option>
                                                        <?php } ?>                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="ci_quantity">
                                                <div class="quantity_counter">
                                                    <button class="minus" type="button" onclick="website.change_count('<?= $productValue['productId'] ?>','minus')">&minus;</button>
                                                    <input class="quantity" id="quantity_<?= $productValue['productId'] ?>" type="number" value="<?= $productValue['productQty'] ?>" min="1" readOnly="true">
                                                    <button class="plus" type="button" onclick="website.change_count('<?= $productValue['productId'] ?>','add')">&plus;</button>
                                                </div>
                                            </div>
                                            <div class="ci_price" id="total_<?= $productValue['productId'] ?>">$ <?= $productValue['productPrice']*$productValue['productQty'] ?></div>
                                        </div>
                                        <div class="links">
                                            <a href="javascript:;">
                                                <i class="icon_favorite_heart_small"></i>
                                                <span>save to heart</span>
                                            </a>
                                            <a class="btn_delete" data-productid="<?= $productValue['productId'] ?>" href="javascript:;">
                                                <i class="icon_remove"></i>
                                                <span>remove</span>
                                            </a>
                                        </div>
                                    </li>   
                                <?php }  ?>
                            </ul>
                        </div>
                        <div class="cart_summary">
                            <ul class="summary_items">
                                <li class="item">
                                <div class="controls_group">
                                    <label>Item Total</label>
                                </div>
                                <div class="price" id="item_total">$ <?= $cart_total ?></div>
                                </li>
                                <li class="item">
                                <div class="controls_group">
                                    <label>Shipping to</label>
                                    <div class="controls">
                                        <div class="select_wrapper">
                                            <select id="shipping_select">
                                                <option value="">choose shipping</option>
                                                <?php foreach ($shippingList as $shippingKey => $shippingValue){ ?>
                                                    <option value="<?= $shippingValue->shippingId ?>" <?= $shippingValue->shippingId == $shippingId ? 'selected' : '' ?>><?= $shippingValue->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="price" id="shipping_money">$ <?= $money ?></div>
                                </li>
                                <li class="item">
                                <div class="controls_group">
                                    <label>Add discout coupon</label>
                                    <div class="controls coupon_controls">
                                    <input type="text">
                                    <button class="btn_check" type="button"><i class="icon_check"></i></button>
                                    </div>
                                </div>
                                <div class="price">-$0</div>
                                </li>
                            </ul>
                            <div class="total_calculation">
                                <label>TOTAL</label>
                                <div class="total_amount" id="all_total">NTD$<?= $all_total ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="call_action space_between"><a class="btn common" href="products.html">Continue Shopping</a><a class="btn confirm" href="order_information.html">Checkout</a></div>
                </form>
            </div>
        </div>
    </div>
</main>
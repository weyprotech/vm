<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
            <div class="center_container container">
                <?= $this->load->view('content/member/_aside',array(),true) ?>
                <div class="container_main">
                    <h1 class="block_title">Order Detail</h1>
                    <div class="order_detail_content">
                        <div class="words">
                        <div class="number">No: <?= $order->orderId ?></div>
                        <p>Name: <?= $order->first_name.' '.$order->last_name ?><br>
                            Address: <?= $order->address ?>
                        </p>
                        </div><a class="btn common popup" href="popup_returns.html">Need Returns</a>
                    </div>
                    <div class="rwd_table">
                        <div class="thead">
                        <div class="tr">
                            <div class="th">Status</div>
                            <div class="th">Date</div>
                            <div class="th">Payment</div>
                            <div class="th">Delivery Date</div>
                            <div class="th">Tracking</div>
                        </div>
                        </div>
                        <div class="tbody">
                        <div class="tr">
                            <?php switch($order->status){ 
                                case 0: ?>                                            
                                    <div class="td" data-label="Order number">Go to pay</div>                                          
                                <?php break;
                                case 1: ?>
                                    <div class="td" data-label="Order number">In transit</div>
                                <?php break;
                                case 2: ?>
                                <div class="td" data-label="Order number">Delivered</div>
                                    
                                <?php break;
                            } ?>
                            <div class="td" data-label="Date"><?= $order->date ?></div>
                            <?php switch($order->payway){ 
                                case 0: ?>                                            
                                    <div class="td" data-label="Amount">Credit Card</div>                                          
                                <?php break;
                                case 1: ?>
                                    <div class="td" data-label="Amount">ATM</div>
                                <?php break;
                                case 2: ?>
                                <div class="td" data-label="Amount">Point</div>                                
                                <?php break;
                            } ?>
                            <div class="td" data-label="Payment"><?= $order->delivery_date ?></div>
                            <div class="td" data-label="Status">
                                <?php switch($order->status){ 
                                    case 0: ?>                                                                         
                                    <?php break;
                                    case 1: ?>
                                        <div class="limit_width">
                                            <span class="font_red">In transit</span><br>
                                            <span class="font_gray"><?= $order->tracking ?></span>
                                        </div>
                                    <?php break;
                                    case 2: ?>                                    
                                    <?php break;
                                } ?>
                            </div>
                        </div>
                        </div>
                    </div>
                    <h1 class="block_title">Order Products</h1>
                    <div class="checkout_cart in_detail">
                        <div class="cart_title">
                            <div class="main">Product</div>
                            <div class="label_quantity">Quantity</div>
                            <div class="label_price">Price</div>
                        </div>
                        <div class="cart_container">
                            <ul class="cart_items">
                                <?php foreach($order->productList as $productKey => $productValue){ ?>
                                    <li class="item">
                                        <a class="thumb" href="<?= website_url('product/detail'.'?productId='.$productValue->productId) ?>">
                                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url($productValue->img) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                            </div>
                                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </a>
                                        <div class="content">
                                            <div class="ci_info">
                                                <div class="ci_name"><?= $productValue->name ?></div>
                                                <div class="ci_description"><?= $productValue->description ?></div><br>
                                                <div class="ci_name">size: <?= $productValue->size ?></div>
                                                <div class="ci_name">color: <?= $productValue->color ?></div>
                                            </div>
                                            <div class="ci_quantity"><?= $productValue->qty ?></div>
                                            <div class="ci_price">$<?= $productValue->price ?></div>
                                        </div>
                                    </li>
                                <?php } ?>                                
                            </ul>
                        </div>
                        <div class="cart_summary">
                        <ul class="summary_items">
                            <li class="item">
                                <div class="controls_group">
                                    <label>Item Total</label>
                                </div>
                                <div class="price"><?= ($order->total - $order->shipping + $order->dividend + (!empty($coupon) ? $coupon->coupon_money : 0)) ?></div>
                            </li>                            
                            <li class="item">
                                <div class="controls_group">
                                    <label>Shipping to </label>
                                </div>
                                <div class="price">$<?= $order->shipping ?></div>
                            </li>
                            <li class="item">
                                <div class="controls_group">
                                    <label>Dividend</label>
                                </div>
                                <div class="price">-$<?= $order->dividend ?></div>
                            </li>
                            <li class="item">
                                <div class="controls_group">
                                    <label>Add discout coupon</label>
                                </div>
                                <div class="price">-$<?= (!empty($coupon) ? $coupon->coupon_money : 0) ?></div>
                            </li>
                        </ul>
                        <div class="total_calculation">
                            <label>TOTAL</label>
                            <div class="total_amount">NTD$<?= $order->total ?></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
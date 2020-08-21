<main id="main">
    <div class="order_information page_block bg_gray">
        <div class="block_inner">
            <div class="sopping_steps">
                <div class="step process"><span>Shipping</span></div>
                <div class="step"><span>Payment</span></div>
                <div class="step"><span>Review</span></div>
            </div>
            <form id="information_form" class="container" method="post">
                <div class="container_aside">
                    <h2 class="block_subtitle">Payment Summary</h2>
                    <div class="aside_block">
                        <div class="cart_view">
                            <div class="title"><?= $cart_amount ?> Items</div>
                            <div class="cart_items">
                                <?php foreach ($cart_productList as $productKey => $productValue){ ?>
                                    <div class="item">
                                        <a class="thumb" href="<?= website_url('product/detail').'?productId='.$productValue['productId'] ?>">
                                        <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                                            <div class="pic" style="background-image: url(<?= backend_url($productValue['productImg']) ?>);">
                                                <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                            </div>
                                        <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                                        </a>
                                        <div class="content">
                                            <div class="price">$ <?= $productValue['productPrice'] ?></div>
                                            <ul>
                                                <li>size: <?= $productValue['productSize'] ?></li>
                                                <li>color: <?= $productValue['productColor'] ?></li>
                                                <li>Qty: <?= $productValue['productQty'] ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="cart_foot">
                                <div class="total_calculation">
                                    <div class="label">TOTAL</div>
                                    <div class="total_amount">NTD $<?= $cart_total ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aside_block has_padding">
                        <h3 class="aside_title">Notice</h3>
                        <div class="text">Bushwick meh Blue Bottle pork belly mustache skateboard 3 wolf moon. Actually beard single-origin coffee, twee 90's PBR Echo Park sartorial try-hard freegan Portland ennui. </div>
                    </div>
                    <div class="aside_block has_padding">
                        <h3 class="aside_title">Customer Notes</h3>
                        <textarea class="note_textarea" name="notes"></textarea>
                    </div>
                </div>
                <div class="container_main">
                    <div class="form_wrapper">
                        <h2 class="block_subtitle">Shipping Address</h2>
                        <div class="form_block">
                            <div class="row">
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>*First Name</label>
                                        <div class="controls">
                                            <input type="text" name="first_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>*Last Name</label>
                                        <div class="controls">
                                            <input type="text" name="last_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>*Country</label>
                                        <div class="controls">
                                            <div class="select_wrapper">
                                                <select name="country">
                                                    <?php foreach($all_country as $countryKey => $countryValue){ ?>
                                                        <option><?= $countryValue['en'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid g_6_12">
                                    <div class="controls_group">
                                        <label>*State/Region</label>
                                        <div class="controls">
                                            <div class="select_wrapper">
                                                <input type="text" name="state" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="grid">
                                    <div class="controls_group">
                                        <label>*Address</label>
                                        <div class="controls">
                                            <input type="text" name="address" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="grid">
                                    <div class="controls_group">
                                        <label>*Phone</label>
                                        <div class="controls row phone_controls">
                                            <div class="grid g_6_12">
                                                <div class="select_wrapper">
                                                    <select name="phone_code">
                                                        <?php foreach($all_country as $countryKey => $countryValue){ ?>
                                                            <option value="<?= $countryValue['code'] ?>"><?= $countryValue['en'] ?>(<?= $countryValue['code'] ?>)</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="grid g_6_12">
                                                <input type="text" name="phone" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(!isset($this->session->userdata('memberinfo')['memberId'])){ ?>
                        <div class="form_wrapper">
                            <h2 class="block_subtitle">Email account</h2>
                            <div class="form_block">
                                <div class="controls_group">
                                    <label>*Email</label>
                                    <div class="controls">
                                        <input type="email" name="email" required>
                                    </div>
                                </div>
                                <div class="controls_group">
                                    <label>*Password</label>
                                    <div class="controls">
                                        <input type="password" id="password" name="password" required>
                                    </div>
                                </div>
                                <div class="controls_group">
                                    <label>*Password confirmed</label>
                                    <div class="controls">
                                        <input type="password" id="password_confirmed" name="password_confirmed" required>
                                    </div>
                                </div>
                            </div>
                        </div>                                             
                    <?php } ?>
                    <div class="accept_captcha">
                            <label class="check_wrapper accept_check">
                                <input type="checkBox" id="agree" name="agree" required>
                                <span>I accept the “Terms &amp; Conditions” and “Privacy Statement”</span>
                            </label>
                            <div class="captcha">
                                <div class="captcha_inner">
                                    <div class="g-recaptcha" data-sitekey="6LcHGhITAAAAABIgEAplK2EWsVFkaE5o0DWUpsIs"></div>
                                </div>
                            </div>
                        </div>   
                    <div class="call_action space_between">
                        <a class="btn common" href="<?= website_url('order') ?>">Cancel</a>
                        <button class="btn confirm" id="information_btn" type="button">Continue</button>
                        <button type="submit" class="hide" style="display:none;"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
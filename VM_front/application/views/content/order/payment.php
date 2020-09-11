<main id="main">
    <div class="order_payment page_block bg_gray">
        <div class="block_inner">
        <div class="sopping_steps">
            <div class="step process"><span>Shipping</span></div>
            <div class="step process"><span>Payment</span></div>
            <div class="step"><span>Review</span></div>
        </div>
        <form class="payment_block">
            <div class="total_calculation">
            <label>TOTAL</label>
            <div class="total_amount">NTD $10,160</div>
            </div>
            <div class="payment_method">
            <h2 class="block_subtitle">Payment method</h2>
            <div class="method_items">
                <div class="item">
                <label class="radio_wrapper">
                    <input type="radio" name="paymentRadio"><span>Credit Card</span>
                </label>
                </div>
                <div class="item">
                <label class="radio_wrapper">
                    <input type="radio" name="paymentRadio"><span>ATM</span>
                </label>
                </div>
                <div class="item">
                <label class="radio_wrapper">
                    <input type="radio" name="paymentRadio"><span>My account deduction</span>
                </label>
                <div class="controls_group">
                    <label>My points :</label>
                    <div class="controls">
                    <input type="text" value="$50,000" readonly="true">
                    </div>
                </div>
                </div>
            </div>
            <div class="call_action">
                <!--↓ 如果是選 ATM 付款，連結至 order_view_atm.html ↓--><a class="btn confirm" href="order_view.html">Submit Order</a>
                <!--↑ 如果是選 ATM 付款，連結至 order_view_atm.html ↑-->
            </div>
            </div>
        </form>
        </div>
    </div>
</main>
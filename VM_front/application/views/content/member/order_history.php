<main id="main">
    <div class="member_center page_block">
        <div class="block_inner">
            <div class="center_container container">
                <?= $this->load->view('content/member/_aside',array(),true) ?>
                <div class="container_main">
                    <h1 class="block_title">Order history</h1>
                    <div class="words">
                        <p>The order is valid for 30 days. After 30 days of completing the order, the order will be automatically cancelled if the payment has not been completed.</p>
                    </div>
                    <div class="rwd_table">
                        <div class="thead">
                        <div class="tr">
                            <div class="th">Order number</div>
                            <div class="th">Date</div>
                            <div class="th">Amount</div>
                            <div class="th">Payment</div>
                            <div class="th">Status</div>
                        </div>
                        </div>
                        <div class="tbody">
                            <?php foreach ($orderList as $orderKey => $orderValue){ ?>
                            <!--↓ 使用刷卡付款 - 連結至 member_history_detail.html ↓-->
                            <!--↓ 使用ATM付款 - 連結至 member_history_detail_atm.html ↓-->
                            <a class="tr" href="member_history_detail.html">
                                <div class="td" data-label="Order number">
                                    <span class="font_khaki"><?= $orderValue->orderId ?></span>
                                </div>
                                <div class="td" data-label="Date"><?= $orderValue->date ?></div>
                                <div class="td" data-label="Amount">$ <?= $orderValue->total ?></div>
                                <div class="td" data-label="Payment">
                                    <span class="font_khaki"><?= $orderValue->status == 0 ? "Unpaid" : "Paid" ?></span>
                                </div>
                                <div class="td" data-label="Status">
                                    <span class="font_khaki"><?= $orderValue->status == 0 ? "Go to pay" : "Paid" ?></span>
                                </div>
                            </a>
                            <?php } ?>    
                                <a class="tr" href="member_history_detail_atm.html">
                                <div class="td" data-label="Order number"><span class="font_khaki">192304832579</span></div>
                                <div class="td" data-label="Date">2019/08/19</div>
                                <div class="td" data-label="Amount">$ 8,000</div>
                                <div class="td" data-label="Payment">Paid</div>
                                <div class="td" data-label="Status"><span class="font_red">In transit</span></div></a><a class="tr" href="member_history_detail.html">
                                <div class="td" data-label="Order number"><span class="font_khaki">192374032575</span></div>
                                <div class="td" data-label="Date">2019/08/19</div>
                                <div class="td" data-label="Amount">$ 9,900</div>
                                <div class="td" data-label="Payment">Paid</div>
                                <div class="td" data-label="Status">Delivered</div></a><a class="tr" href="member_history_detail_atm.html">
                                <div class="td" data-label="Order number"><span class="font_khaki">192305332957</span></div>
                                <div class="td" data-label="Date">2019/08/19</div>
                                <div class="td" data-label="Amount">$ 10,800</div>
                                <div class="td" data-label="Payment">Paid</div>
                                <div class="td" data-label="Status">Delivered</div></a>
                            <!--↑ 使用刷卡付款 - 連結至 member_history_detail.html ↑-->
                            <!--↑ 使用ATM付款 - 連結至 member_history_detail_atm.html ↑-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
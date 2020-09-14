<main id="main">
    <div class="order_view page_block">
        <div class="block_inner">
        <h2 class="block_subtitle">Thank you for your order :)</h2>
        <table class="order_table">
            <tr>
            <th>Order Number</th>
            <td>No.<?= $order->orderId ?></td>
            </tr>
            <tr>
            <th>Date</th>
            <td><?= $order->date ?></td>
            </tr>
            <tr>
            <th>Total</th>
            <td><span class="font_red">NT $<?= $order->total ?></span></td>
            </tr>
        </table>
        <div class="call_action"><a class="btn confirm" href="javascript:;">Order Detail</a></div>
        </div>
    </div>
</main>
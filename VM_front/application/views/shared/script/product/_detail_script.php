<script>
    function processingCompleted($btn) {
        $btn.removeClass('processing');
        
        // Noty - https://ned.im/noty/
        new Noty({
            type: 'success',
            layout: 'bottomCenter',
            theme: 'nest',
            text: 'Added to bag.', //可以在這裡改變顯示的文字
            timeout: 5000,
            closeWith: ['click', 'button']
        }).show();
    }

    $(function() {
        var cart;
        $(".btn.addCart").on('click', function() {
            var obj = $(this);
            clearTimeout(cart);
            cart = setTimeout(function() {
                obj.addClass('processing');

                var productid = obj.data('productid');
                var size = $("#size").val();
                var color = $("#color").val();
                var quantity = $("#quantity").val();

                $.post(
                    '<?=site_url('ajax/shopping/addtocart')?>',
                    { 
                        'productid' : productid,
                        'quantity' : quantity,
                        'size' : size,
                        'color' : color
                    }, 
                    function (res) {
                        var contact = JSON.parse(res);

                        if(contact.code.trim() == "200")
                        {
                            processingCompleted($(obj));
                        }
                    }
                );
            }, 1000);
        });

        // 愛心的點擊事件
        $(document).on('click', '.btn_favorite', function(event) {
            // productId 取得設計師的 ID
            var productId = $(this).attr('data-productId');
        
            if ($(this).hasClass('active')) {
                // 取消最愛寫這裡
                $.ajax({
                    url:'<?= website_url('ajax/product/set_like') ?>',
                    type:'post',
                    dataType:'json',
                    data:{productId : productId},
                    success: function(response){
                        if(response['status'] == 'error'){
                            swal({
                                title:'please login',
                                type:'warning',
                            }).then(function(response){
                                window.location = '<?= website_url('login') ?>';
                            });
                           $('.swal2-container').css('z-index','100000');
                        }
                    }
                })
                $(this).removeClass('active');
            } else {
                // 加入最愛寫這裡
                $.ajax({
                    url:'<?= website_url('ajax/product/set_like') ?>',
                    type:'post',
                    dataType:'json',
                    data:{productId : productId},
                    success: function(response){
                        if(response['status'] == 'error'){
                            swal({
                                title:'please login',
                                type:'warning',
                            }).then(function(response){
                                window.location = '<?= website_url('login') ?>';
                            });
                           $('.swal2-container').css('z-index','100000');                            
                        }
                    }
                })
                $(this).addClass('active');
            }
        });
    });
</script>
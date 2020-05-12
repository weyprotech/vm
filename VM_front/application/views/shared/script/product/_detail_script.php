<script>
    $(function() {
        var cart;
        $(".addtocart").on('click', function() {
            clearTimeout(cart);
            cart = setTimeout(function() {
                var productId = $(this).data('productId');
                var size = $("#size").val();
                var color = $("#color").val();
                var quantity = $("#quantity").val();

                $.post(
                    '<?=site_url('ajax/shopping/addtocart')?>',
                    { 
                        'productId' : productId,
                        'quantity' : quantity,
                        'size' : size,
                        'color' : color
                    }, 
                    function (res) {
                        var contact = JSON.parse(res);

                        if(contact.code.trim() == "200")
                        {
                            
                        }
                    }
                );
            }, 1500);
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
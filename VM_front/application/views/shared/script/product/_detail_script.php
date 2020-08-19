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

                $.ajax({
                    url:'<?=site_url('ajax/shopping/addtocart')?>',
                    data: { 
                        'productid' : productid,
                        'quantity' : quantity,
                        'size' : size,
                        'color' : color
                    }, 
                    type:'post',
                    dataType:'json',
                    success: function (res) {
                        console.log(res);
                        if(res['status']){
                            processingCompleted($(obj));
                            $('.cart_view').find('.title').html(res['cart_amount']+' Items');
                            console.log(res['cart_productList']);
                            $('.cart_view').find('.cart_items').html('');
                            $.each(res['cart_productList'],function(key,value){
                                $('.cart_view').find('.cart_items').append(
                                    '<div class="item">'+
                                        '<a class="btn_delete" href="javascript:;"><i class="icon_delete"></i></a>'+
                                        '<a class="thumb" href="<?= website_url('product/detail').'?productId='?>'+value.productId+'">'+
                                            '<div class="pic" style="background-image: url(<?= backend_url() ?>'+value.productImg+');">'+
                                                '<img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">'+
                                            '</div>'+                                            
                                        '</a>'+
                                        '<div class="content">'+
                                            '<div class="price">$ '+value.productPrice+'</div>'+
                                            '<ul>'+
                                                '<li>size: '+value.productSize+'</li>'+
                                                '<li>color: '+value.productColor+'</li>'+
                                                '<li>Qty: '+value.productQty+'</li>'+
                                            '</ul>'+
                                        '</div>'+
                                    '</div>'
                                );
                            });
                            $('.total_calculation').find('.total_amount').html('NTD $'+res['cart_total']);
                        }
                    }
                });
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
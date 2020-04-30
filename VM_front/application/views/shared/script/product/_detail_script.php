<script>
    $(function() {
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
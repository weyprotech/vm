<script>
    $(function() {
        // favorite 加入愛心的點擊事件
        $(document).on('click', '.btn_favorite', function() {
            // designerId 取得穿搭的 ID
            var designerId = $(this).attr('data-designerId');
        
            if ($(this).hasClass('active')) {
                // 取消最愛寫這裡
                $.ajax({
                    url:'<?= website_url('ajax/designers/set_like') ?>',
                    type:'post',
                    dataType:'json',
                    data:{designerId : designerId},
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
                    url:'<?= website_url('ajax/designers/set_like') ?>',
                    type:'post',
                    dataType:'json',
                    data:{designerId : designerId},
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
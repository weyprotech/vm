<script src="<?=base_url('assets/scripts/plugins/countdown.js') ?>"></script>

<script>
    $(function() {
        // 愛心的點擊事件
        $(document).on('click', '.btn_favorite', function(event) {
            // designerId 取得設計師的 ID
            var designerId = $(this).attr('data-designerId');
            var countNumber = parseInt($(this).find('.count').text());
        
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
                $(this).find('.count').text(countNumber - 1);
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
                $(this).find('.count').text(countNumber + 1);
            }
        });
    });
</script>
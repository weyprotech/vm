<script>
    <?php if($type == 'success'){ ?>
        swal({
            html:'Success',
            type:'success'
        });
        $('.swal2-container').css('z-index','100000');
    <?php }elseif($type == 'error'){ ?>
        swal({
            html:'Please check the verification code',
            type:'warning'
        });
        $('.swal2-container').css('z-index','100000');
    <?php } ?>
</script>
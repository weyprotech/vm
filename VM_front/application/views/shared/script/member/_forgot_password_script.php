<script>
    <?php if($type == 'success'){ ?>
        swal({
            html:'New password has been send',
            type:'success'
        });
        $('.swal2-container').css('z-index','100000');

    <?php } ?>
</script>
<script>
    <?php if(!empty($type)){ ?>
        swal({
            title:'Success',
            type:'success'
        });
        $('.swal2-container').css('z-index','100000');

    <?php } ?>
    $('#edit_account_save').on('click',function(){
        var password = $('#password').val();
        var password_confirm = $('#confirm_password').val();
        var error = 0;
        if(password == ''){
            $('#password').css('border-color','red');
            error = 1;
        }
        if(password_confirm == ''){
            $('#password_confirm').css('border-color','red');
            error = 1;
        }
        if(error == 0){
            console.log(password);
            console.log(password_confirm);
            if(password == password_confirm){
                $('#edit_account_form').submit();
            }else{
                swal({
                    html:'password and password confirmation is not match',
                    type:'error'
                });
                // $('#password').val('');
                // $('#password_confirm').val('');
                $('.swal2-container').css('z-index','100000');
            }
        }
    });
</script>
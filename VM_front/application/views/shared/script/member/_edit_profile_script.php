<script src="<?= base_url("assets/scripts/plugins/exif.js") ?>"></script>
<script>
    $(function() {
        if (window.File && window.FileList && window.FileReader) {
            $('.upload_photo').each(function() {
            var $upPic = $(this).find('.upload_pic'),
                $upBtn = $(this).find('.upload_btn'),
                $upInput = $(this).find('.upload_input');
            
            $upBtn.on('click', function() {
                $upInput.click();
            });
            $upInput.on("change", function(e) {
                var files = e.target.files;
                var f = files[0]
                var fileReader = new FileReader();
        
                fileReader.onload = (function(e) {
                var file = e.target;
                var image = new Image();
        
                image.src = file.result;
                image.onload = function() {
                    var canvas = document.createElement("canvas");
                    compressCtx = canvas.getContext("2d");
                    
                    EXIF.getData(image, function(){
                    EXIF.getAllTags(this);
                    var orientation = EXIF.getTag(this, 'Orientation');
                    switch(orientation) {
                        case 1:
                        var resizeW = 200;
                        var resizeH = resizeW * (image.height / image.width);
                        canvas.width = resizeW;
                        canvas.height = resizeH;
                        compressCtx.clearRect(0, 0, canvas.width, canvas.height)
                        compressCtx.drawImage(image, 0, 0, resizeW, resizeH);
                        break;
                        case 6:
                        var resizeW = 200;
                        var resizeH = resizeW * (image.width/ image.height);
                        canvas.width = resizeW;
                        canvas.height = resizeH;
                        compressCtx.clearRect(0, 0, canvas.width, canvas.height)
                        compressCtx.translate(0, 0);
                        compressCtx.rotate(90 * Math.PI / 180);
                        compressCtx.drawImage(image, 0, -resizeW, resizeH, resizeW);
                        break;
                        case 8:
                        var resizeW = 200;
                        var resizeH = resizeW * (image.width/ image.height);
                        canvas.width = resizeW;
                        canvas.height = resizeH;
                        compressCtx.clearRect(0, 0, canvas.width, canvas.height)
                        compressCtx.translate(0, 0);
                        compressCtx.rotate(-90 * Math.PI / 180);
                        compressCtx.drawImage(image, -resizeH, 0, resizeH, resizeW);
                        break;
                        case 3:
                        var resizeW = 200;
                        var resizeH = resizeW * (image.height / image.width);
                        canvas.width = resizeW;
                        canvas.height = resizeH;
                        compressCtx.clearRect(0, 0, canvas.width, canvas.height)
                        compressCtx.translate(0, 0);
                        compressCtx.rotate(Math.PI);
                        compressCtx.drawImage(image, -resizeW, -resizeH, resizeW, resizeH);
                        break;
                        default:
                        var resizeW = 200;
                        var resizeH = resizeW * (image.height / image.width);
                        canvas.width = resizeW;
                        canvas.height = resizeH;
                        compressCtx.clearRect(0, 0, canvas.width, canvas.height)
                        compressCtx.drawImage(image, 0, 0, resizeW, resizeH);
                        break;
                    }
                    var base64 = canvas.toDataURL("image/jpeg", .5);
                    $upPic.css('background-image', 'url("' + base64 + '")');
                    $('form').append('<input id="" type="hidden" name="memberImg" value="'+base64+'">');

                    });
                }
                });
                fileReader.readAsDataURL(f);
            });
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
    <?php if(!empty($type)){ ?>
        swal({
            title:'Success',
            type:'success'
        });
        $('.swal2-container').css('z-index','100000');

    <?php } ?>
</script>
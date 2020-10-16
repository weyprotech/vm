<style type="text/css">
    .help-block #preview {
        width: auto;
        max-width: 90%;
        max-height: 300px;
        margin-bottom: 6px;
        padding: 3px;
    }
</style>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12">
            <?php if ($active = get_cookie('active')): ?>
                <div class="alert alert-<?= $active['status'] ?> alert-block">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><?= $active['message'] ?></h4>
                </div>
            <?php endif; ?>

            <div class="jarviswidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false"
                 data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>

                    <h2>Edit</h2>
                    <ul class="nav nav-tabs pull-right in"><?php $i = 1; ?>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>
                    </ul>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form id="data-form" class="form-horizontal" method="post" enctype="multipart/form-data"
                            data-bv-message="This value is not valid"
                            data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                            data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                            data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                            <input type="hidden" name="uuid" value="<?= $row->uuid ?>">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Money</legend>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="eur_value">1 USD =</label>

                                            <div class="col-sm-2">
                                                <input type="text" class="form-control EUR_title" name="eur_value" data-bv-notempty="true" data-bv-notempty-message=" " value="<?= $row->eur_value ?>">                                                     
                                            </div>
                                            <label class="control-label" for="twd_value">EUR</label>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="twd_value">1 USD =</label>

                                            <div class="col-sm-2">
                                                <input type="text" class="form-control EUR_title" name="twd_value" data-bv-notempty="true" data-bv-notempty-message=" " value = "<?= $row->twd_value ?>">                                                    
                                            </div>
                                            <label class="control-label" for="twd_value">TWD</label>
                                        </div>
                                    </fieldset>
                                </div>                            
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save" form="data-form">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/clockpicker/clockpicker.min.js") ?>"></script>
<link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/summernote.css") ?>">
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote-zh-TW.js") ?>"></script>
<script>
    var hash = window.location.hash;
    $('ul.nav-tabs li').eq(hash.substr(1)).addClass('active');
    $('.tab-pane').eq(hash.substr(1)).addClass('active');

    var $cId = $("#cId");
    $(document).ready(function () {
        $('input#uploadImg').change(function () {
            var $this = $(this);
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                $this.siblings('p:last').children('img#preview').attr('src', e.target.result).show();
            };
        });

        $("#save, #back").click(function (e) {
            $('div#content-edit').each(function () {
                var content = $(this).summernote('code').replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
                    return '&#' + i.charCodeAt(0) + ';';
                });

                $(this).siblings('input#content').val(content);
            });
        });
        
        $('div#content-edit').each(function () {
            $(this).summernote({
                height: 500,
                lang: 'zh-TW',
                toolbar: [
                    ['font', ['clear']],
                    ['insert', ['picture', 'link', 'video']],
                    ['misc', ['codeview']]
                    //['font', ['fontname', 'fontsize', 'color', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subsript', 'clear']],
                    //['para', ['style', 'ol', 'ul', 'paragraph', 'height']],
                    //['insert', ['picture', 'link', 'video', 'table', 'hr']],
                    //['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
                ],
                callbacks: {
                    onImageUpload: function (files) {
                        for (var i = 0; i < files.length; i++) {
                            sendFile(files[i], $(this));
                        }
                    }
                }
            });
        });

        $('#category').on('change',function(){
            if($(this).val() == 0){
                $('#exploreImg').css('display','block');
                $('#data-form').bootstrapValidator('resetField', 'collectionyoutube');
                $("#data-form").bootstrapValidator('enableFieldValidators', 'collectionyoutube', false);
                $('#collectionImg').css('display','none');
                $('#collectionyoutube').css('display','none');
            }else{
                $('#collectionImg').css('display','block');
                $('#collectionyoutube').css('display','block');
                $("#data-form").bootstrapValidator('enableFieldValidators', 'collectionyoutube', true);  
                $('#exploreImg').css('display','none');
            }
        });

        $('form').bootstrapValidator({
            excluded: ""
        });         
    });
</script>
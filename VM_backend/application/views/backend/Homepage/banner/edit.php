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
                        <?php if ($this->langList): ?>
                            <?php foreach ($this->langList as $lrow): ?>
                                <li><a data-toggle="tab" href="#hb<?= $i++ ?>"><?= $lrow->name ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form id="data-form" class="form-horizontal" method="post" enctype="multipart/form-data"
                            data-bv-message="This value is not valid"
                            data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                            data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                            data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                            <input type="hidden" name="is_enable" value="1">
                            <input type="hidden" name="uuid" value="<?= $row->uuid ?>">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Banner</legend>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Visible</label>

                                            <div class="col-sm-9">
                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox" name="is_visible" value="1" <?= $row->is_visible ? "checked" : "" ?>>
                                                    <span>Yes</span>
                                                </label>

                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox" name="is_visible" value="0" <?= !$row->is_visible ? "checked" : "" ?>>
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Banner Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="bannerImg"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="Type error">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>1920 x 355</strong>. Format is JPG and PNG</strong>。
                                                </p>
                                                <p class="help-block">
                                                    <?php $bannerImg = check_file_path($row->bannerImg); ?>
                                                    <img id="preview" src="<?= $bannerImg ?>"<?= !$bannerImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>                                    
                                          
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Sort</label>

                                            <div class="col-sm-1">
                                                <input class="form-control" name="order" value="<?= $row->order ?>">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <?php $langData = @$row->langList[$lrow->langId]; ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">  
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][bId]" value="<?= $row->bannerId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">

                                            <fieldset data-id="<?= $lrow->langId ?>">
                                                <legend>Banner Content</legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control brand_name" name="langList[<?= $lrow->langId ?>][title]" value="<?= @$langData->title ?>" data-bv-notempty="true" data-bv-notempty-message=" ">                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">SubTitle</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][sub_title]" value="<?= @$langData->sub_title ?>" data-bv-notempty="true" data-bv-notempty-message=" ">                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][content]" rows="15" data-bv-notempty="true" data-bv-notempty-message=" "><?= @$langData->content ?></textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save" form="data-form">Save</button>
                                <button type="submit" class="btn btn-primary" id="back" form="data-form" onclick="$('#data-form').attr('action', '<?= $this->query . (!empty($this->query) ? '&' : '?') ?>back=1');">Return After Saving</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/homepage/banner" . $this->query) ?>';">Return</button>
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
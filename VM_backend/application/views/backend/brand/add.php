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
                            <input type="hidden" name="brandId" value="<?= $brandId ?>">
                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Brand</legend>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Visible</label>

                                            <div class="col-sm-9">
                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox" name="is_visible" value="1" checked>
                                                    <span>Yes</span>
                                                </label>

                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox" name="is_visible" value="0">
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="designerId">Designer</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" id="designerId" name="designerId">
                                                    <?php foreach($designerList as $designKey => $designValue){ ?>
                                                        <option value="<?= $designValue->designerId ?>"><?= $designValue->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="country">Country</label>
                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" name="country">
                                                    <?php $countryList = get_all_country();
                                                    foreach($countryList as $countryKey => $countryValue){ ?>
                                                        <option value="<?= $countryKey ?>"><?= $countryValue ?></option>
                                                    <?php } ?>  
                                                </select>                                                      
                                            </div>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label class="col-sm-2 control-label" for="date">日期</label>

                                            <div class="col-sm-9 col-lg-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker" id="date" name="date" value="<?= $row->date ?>" data-dateformat="yy-mm-dd" placeholder="選擇日期" required>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Icon</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandiconImg"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="圖示格式不符">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture size is <strong>100 x 100</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                   
                                                    <img id="preview" src="">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Img</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandImg"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="圖示格式不符">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture size is <strong>600 x 600</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <img id="preview" src="">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">List Img</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandindexImg"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="圖示格式不符">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture size is <strong>360 x 360</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <img id="preview" src="">
                                                </p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">  
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][brandId]" value="<?= $brandId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">

                                            <fieldset data-id="<?= $lrow->langId ?>">
                                                <legend>Brand Information</legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Brand Name</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control brand_name" name="langList[<?= $lrow->langId ?>][name]" data-bv-notempty="true" data-bv-notempty-message=" ">                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][content]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "></textarea>
                                                    </div>
                                                </div>

                                                <legend>Brand Story</legend>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][brand_story_title]" data-bv-notempty="true" data-bv-notempty-message=" ">                                                                                                                
                                                    </div>
                                                </div>

                                                <!-- <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Youtube</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][brand_story_youtube]">                                                                                                                
                                                    </div>
                                                </div> -->

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Content</label>

                                                    <div class="col-sm-9">
                                                        <div id="content-edit"></div>
                                                        <input type="hidden" id="content" name="langList[<?= $lrow->langId ?>][brand_story_content]">
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
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/brand/brand" . $this->query) ?>';">Return</button>
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

        $('form').bootstrapValidator({
            excluded: ""
        });
    });
</script>
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
                                        <legend>Brand</legend>
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
                                            <label class="col-sm-2 control-label" for="designerId">Designer</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" id="designerId" name="designerId">
                                                    <?php foreach($designerList as $designKey => $designValue){ ?>
                                                        <option value="<?= $designValue->designerId ?>" <?= $designValue->designerId == $row->designerId ?>><?= $designValue->name ?></option>
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
                                                        <option value="<?= $countryKey ?>" <?= (@$row->country == $countryKey) ? 'selected' : '' ?>><?= $countryValue ?></option>
                                                    <?php } ?>  
                                                </select>                                                      
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="locationId">Map location</label>
                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" name="locationId">
                                                    <option value="<?= $location->Id ?>" selected><?=  $location->number.' '.$location->stree ?></option>
                                                    <?php foreach($locationList as $locationKey => $locationValue){ ?>
                                                        <option value="<?= $locationValue->Id ?>"><?=  $locationValue->number.' '.$locationValue->stree ?></option>
                                                    <?php } ?>  
                                                </select>                                                      
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Icon</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandiconImg"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalid">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>100 x 100</strong>. Format is JPG and PNG</strong>。
                                                </p>
                                                <p class="help-block">
                                                    <?php $brandiconImg = check_file_path($row->brandiconImg); ?>
                                                    <img id="preview" src="<?= $brandiconImg ?>"<?= !$brandiconImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandImg"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalid">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>600 x 600</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $brandImg = check_file_path($row->brandImg); ?>
                                                    <img id="preview" src="<?= $brandImg ?>"<?= !$brandImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>                                       

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">List Img</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandindexImg"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalid">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>360 x 360</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $brandindexImg = check_file_path($row->brandindexImg);?>
                                                    <img id="preview" src="<?= $brandindexImg ?>"<?= !$brandindexImg ? 'display:none;' : '' ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Brand Story2 Image-1</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandstory2_1Img"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalid">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>940 x 1154</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $brandstory2_1Img = check_file_path($row->brandstory2_1Img);?>
                                                    <img id="preview" src="<?= $brandstory2_1Img ?>"<?= !$brandstory2_1Img ? 'display:none;' : '' ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Bramd Story2 Image-2</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandstory2_2Img"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalid">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>941 x 968</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <?php $brandstory2_2Img = check_file_path($row->brandstory2_2Img);?>
                                                    <img id="preview" src="<?= $brandstory2_2Img ?>"<?= !$brandstory2_2Img ? 'display:none;' : '' ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Brand Stroy2 Image-3</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="brandstory2_3Img"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalid">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>940 x 865</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <?php $brandstory2_3Img = check_file_path($row->brandstory2_3Img);?>
                                                    <img id="preview" src="<?= $brandstory2_3Img ?>"<?= !$brandstory2_3Img ? 'display:none;' : '' ?>>
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
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][brandId]" value="<?= $brandId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">

                                            <fieldset data-id="<?= $lrow->langId ?>">
                                                <legend>Brand Information</legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Brand Name</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control brand_name" name="langList[<?= $lrow->langId ?>][name]" value="<?= @$langData->name ?>">                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][content]" rows="10"><?= @$langData->content ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][brand_story_title]" value="<?= @$langData->brand_story_title ?>">                                                                                                                
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Content</label>

                                                    <div class="col-sm-9">
                                                        <div id="content-edit"><?= @$langData->brand_story_content ?></div>
                                                        <input type="hidden" id="content" name="langList[<?= $lrow->langId ?>][brand_story_content]">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story2 Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][brand_story_title2]" value="<?= @$langData->brand_story_title2 ?>">                                                                                                                
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story2 Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][brand_story_content2]" rows="10"><?= @$langData->brand_story_content2 ?></textarea>
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

    function sendFile(file, editor) {
        var data = new FormData();
        data.append('brandId', '<?= $row->brandId ?>');
        data.append("file", file);

        return $.ajax({
            data: data,
            type: "POST",
            url: "<?= site_url("backend/ajax/brand/brand/upload") ?>",
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                editor.summernote('editor.insertImage', url);
            }
        });
    }
</script>
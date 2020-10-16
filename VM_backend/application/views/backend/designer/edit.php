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
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">content</a></li>
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

                            <input type="hidden" name="uuid" value="<?= $row->uuid ?>">
                            <input type="hidden" name="is_enable" value="1">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Designer</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">visible</label>

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
                                            <label class="col-sm-2 control-label">Designer Story</label>

                                            <div class="col-sm-9">
                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox designer_story" name="is_designer_story" value="1" <?= $row->is_designer_story == 1 ? 'checked="checked"' : '' ?>>
                                                    <span>Yes</span>
                                                </label>

                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox designer_story" name="is_designer_story" value="0" <?= $row->is_designer_story == 0 ? 'checked="checked"' : '' ?>>
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Icon</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="designiconImg"
                                                data-bv-file="true"
                                                data-bv-file-extension="jpeg,jpg,png,gif"
                                                data-bv-file-type="image/jpeg,image/png,image/gif"
                                                data-bv-file-message="File invalide">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>100 x 100</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $designiconImg = check_file_path($row->designiconImg); ?>
                                                    <img id="preview" src="<?= $designiconImg ?>"<?= !$designiconImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="designImg"
                                                data-bv-file="true"
                                                data-bv-file-extension="jpeg,jpg,png,gif"
                                                data-bv-file-type="image/jpeg,image/png,image/gif"
                                                data-bv-file-message="File invalide">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>540 x 720</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $designImg = check_file_path($row->designImg); ?>
                                                    <img id="preview" src="<?= $designImg ?>"<?= !$designImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group designer_story_img" <?= $row->is_designer_story == 1 ? 'style="display:block"' : 'style="display:none;"'  ?>>
                                            <label class="col-sm-2 control-label">Designer Story Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="designerstoryImg"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalid">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>510 x 288</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <?php $designerstoryImg = check_file_path($row->designerstoryImg); ?>
                                                    <img id="preview" src="<?= $designerstoryImg ?>"<?= !$designerstoryImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">About Designer Image</label>

                                            <div class="col-sm-9">
                                                <input class="btn btn-default" type="file" id="uploadImg" name="aboutImg"
                                                data-bv-file="true"
                                                data-bv-file-extension="jpeg,jpg,png,gif"
                                                data-bv-file-type="image/jpeg,image/png,image/gif"
                                                data-bv-file-message="File invalide">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Resolution is <strong>540 x 405</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <?php $aboutImg = check_file_path($row->aboutImg);?>
                                                    <img id="preview" src="<?= $aboutImg ?>"<?= !$aboutImg ? 'display:none;' : '' ?>>
                                                </p>
                                            </div>
                                        </div> 

                                        <legend>My Hometown</legend>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post1 Image</label>

                                                <div class="col-sm-9">
                                                    <input class="btn btn-default" type="file" id="uploadImg" name="hometownpost1Img"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalide">

                                                    <p class="help-block">
                                                        <strong>Note:</strong>Resolution is <strong>540 x 720</strong>. Format is JPG and PNG</strong>。
                                                    </p>

                                                    <p class="help-block">
                                                        <?php $hometownpost1Img = check_file_path($row->hometownpost1Img);?>
                                                        <img id="preview" src="<?= $hometownpost1Img ?>"<?= !$hometownpost1Img ? 'display:none;' : '' ?>>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post2 Image</label>

                                                <div class="col-sm-9">
                                                    <input class="btn btn-default" type="file" id="uploadImg" name="hometownpost2Img"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalide">

                                                    <p class="help-block">
                                                        <strong>Note:</strong>Resolution is <strong>540 x 720</strong>. Format is JPG and PNG</strong>。
                                                    </p>

                                                    <p class="help-block">                                                    
                                                        <?php $hometownpost2Img = check_file_path($row->hometownpost2Img);?>
                                                        <img id="preview" src="<?= $hometownpost2Img ?>"<?= !$hometownpost2Img ? 'display:none;' : '' ?>>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post3 Image</label>

                                                <div class="col-sm-9">
                                                    <input class="btn btn-default" type="file" id="uploadImg" name="hometownpost3Img"
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="File invalide">

                                                    <p class="help-block">
                                                        <strong>Note:</strong>Resolution is <strong>540 x 720</strong>. Format is JPG and PNG</strong>。
                                                    </p>

                                                    <p class="help-block">                                                    
                                                        <?php $hometownpost3Img = check_file_path($row->hometownpost3Img);?>
                                                        <img id="preview" src="<?= $hometownpost3Img ?>"<?= !$hometownpost3Img ? 'display:none;' : '' ?>>
                                                    </p>
                                                </div>
                                            </div>                                           

                                            <legend>Account</legend>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Account</label>

                                                <div class="col-sm-5">
                                                    <input class="form-control" name="account" value="<?= $row->account ?>" data-bv-remote-name="account" data-bv-remote-name-message=" ">                                                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Password</label>

                                                <div class="col-sm-5">
                                                    <input class="form-control" name="password" value="<?= $row->password ?>" data-bv-remote-name="password" data-bv-remote-name-message=" ">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Url</label>

                                                <div class="col-sm-5">
                                                    <input class="form-control" name="url" value="<?= $row->url ?>" data-bv-remote-name="url" data-bv-remote-name-message=" ">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="grade">Grade</label>

                                                <div class="col-sm-5">
                                                    <select class="form-control" id="grade" name="grade">
                                                        <option value="0" <?= $row->grade == 0 ? 'selected' : '' ?>>Normal</option>
                                                        <option value="1" <?= $row->grade == 1 ? 'selected' : '' ?>>Famous</option>
                                                    </select>
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
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][designerId]" value="<?= $row->designerId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">

                                            <fieldset data-id="<?= $lrow->langId ?>">
                                                <legend>Designer Information</legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Designer Name</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control designer_name" name="langList[<?= $lrow->langId ?>][name]" value="<?= @$langData->name ?>" data-bv-notempty="true" data-bv-notempty-message=" ">                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Country</label>

                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="langList[<?= $lrow->langId ?>][country]">
                                                            <?php $countryList = get_all_country();
                                                            foreach($countryList as $countryKey => $countryValue){ ?>
                                                                <option value="<?= $countryKey ?>" <?= (@$langData->country == $countryKey) ? 'selected' : '' ?>><?= $countryValue ?></option>
                                                            <?php } ?>    
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Description</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][description]" rows="10"><?= @$langData->description ?></textarea>
                                                    </div>
                                                </div>

                                                <legend>Designer Story</legend>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][my_story_title]" value="<?= @$langData->my_story_title ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Content</label>

                                                    <div class="col-sm-9">
                                                        <div id="content-edit"><?= @$langData->my_story_content ?></div>
                                                        <input type="hidden" id="content" name="langList[<?= $lrow->langId ?>][my_story_content]">
                                                    </div>
                                                </div>

                                                <legend>Hometown</legend>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][hometown_title]" value="<?= @$langData->hometown_title ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Country</label>

                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="langList[<?= $lrow->langId ?>][hometown_country]">
                                                            <?php $countryList = get_all_country();
                                                            foreach($countryList as $countryKey => $countryValue){ ?>
                                                                <option value="<?= $countryKey ?>" <?= $langData->hometown_country == $countryKey ? 'selected' : '' ?>><?= $countryValue ?></option>
                                                            <?php } ?> 
                                                        </select>                                                       
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Area</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][hometown_area]" value="<?= @$langData->hometown_area ?>">                                                                                                                
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][hometown_content]" rows="10"><?= @$langData->hometown_content ?></textarea>
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post1 Title</label>

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="langList[<?= $lrow->langId ?>][hometown_post1_title]" value="<?= @$langData->hometown_post1_title ?>">
                                                    </div>
                                                </div>                                    

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post1 Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][hometown_post1_content]" rows="10"><?= @$langData->hometown_post1_content ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post2 Title</label>

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="langList[<?= $lrow->langId ?>][hometown_post2_title]" value="<?= @$langData->hometown_post2_title ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post2 Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][hometown_post2_content]" rows="10"><?= @$langData->hometown_post2_content ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post3 Title</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="langList[<?= $lrow->langId ?>][hometown_post3_title]" value="<?= @$langData->hometown_post3_title ?>">                                                   
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post3 Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][hometown_post3_content]" rows="10"><?= @$langData->hometown_post3_content ?></textarea>
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
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/designer/designer" . $this->query) ?>';">Return</button>
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
        $('#data-form').bootstrapValidator('resetField', 'designerstoryImg');
        $("#data-form").bootstrapValidator('enableFieldValidators', 'designerstoryImg', false);
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

        $('form').bootstrapValidator({
            excluded: "",
            fields: {
                url: {
                    message: 'The URL is not valid',
                    validators: {                        
                        remote: {
                            message: 'The URL has been registered',
                            url: '<?= site_url('backend/ajax/designer/designer/check_url') ?>',
                            data: function(validator) {
                                return {
                                    id:'<?= $row->designerId ?>',
                                    url: validator.getFieldElements('url').val()
                                };
                            },
                        },
                        regexp: {
                            regexp: /[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/,
                            message: 'The URL is not valid'
                        }
                    }
                },
                account: {
                    message: 'The account is not valid',
                    validators: {                        
                        remote: {
                            message: 'The account has been registered',
                            url: '<?= site_url('backend/ajax/designer/designer/check_account') ?>',
                            data: function(validator) {
                                return {
                                    id:'<?= $row->designerId ?>',
                                    account: validator.getFieldElements('account').val()
                                };
                            },
                        }
                    }
                }
            }
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

        $('body').on('click','.designer_story',function(){
            if($(this).val() == 1){
                $('.designer_story_img').css('display','block');
                $("#data-form").bootstrapValidator('enableFieldValidators', 'designerstoryImg', true);  
            }else{
                $('.designer_story_img').css('display','none');
                $('#data-form').bootstrapValidator('resetField', 'designerstoryImg');
                $("#data-form").bootstrapValidator('enableFieldValidators', 'designerstoryImg', false);
            }
        });
    });

    function sendFile(file, editor) {
        var data = new FormData();
        data.append('designerId', '<?= $row->designerId ?>');
        data.append("file", file);

        return $.ajax({
            data: data,
            type: "POST",
            url: "<?= site_url("backend/ajax/designer/designer/upload") ?>",
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                editor.summernote('editor.insertImage', url);
            }
        });
    }
</script>
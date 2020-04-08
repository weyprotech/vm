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
                            <input type="hidden" name="designerId" value="<?= $designerId ?>">
                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Designer</legend>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Icon</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="designiconImg"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="Type error">

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
                                                <input type="file" class="btn btn-default" id="uploadImg" name="designImg"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="Type error">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture size is <strong>540 x 720</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <img id="preview" src="">
                                                </p>
                                            </div>
                                        </div>

                                        <legend>My Hometown</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post1 Img</label>

                                            <div class="col-sm-9">
                                                <input class="btn btn-default" type="file" id="uploadImg" name="hometownpost1Img" 
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="Type error">
                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture size is <strong>540 x 720</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <img id="preview" src="">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post2 Img</label>

                                            <div class="col-sm-9">
                                                <input class="btn btn-default" type="file" id="uploadImg" name="hometownpost2Img"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="Type error">
                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture size is <strong>540 x 720</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <img id="preview" src="">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post3 Img</label>

                                            <div class="col-sm-9">
                                                <input class="btn btn-default" type="file" id="uploadImg" name="hometownpost3Img"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="Type error">
                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture size is <strong>540 x 720</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">                                                    
                                                    <img id="preview" src="">
                                                </p>
                                            </div>
                                        </div>

                                        <legend>Account</legend>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Account</label>

                                            <div class="col-sm-5">
                                                <input class="form-control" name="account" data-bv-remote-name="account" data-bv-remote-name-message=" " data-bv-notempty="true" data-bv-notempty-message=" ">                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Password</label>

                                            <div class="col-sm-5">
                                                <input class="form-control" name="password" data-bv-remote-name="password" data-bv-remote-name-message=" " data-bv-notempty="true" data-bv-notempty-message=" ">                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Url</label>

                                            <div class="col-sm-5">
                                                <input class="form-control" name="url" data-bv-remote-name="url" data-bv-remote-name-message=" " data-bv-notempty="true" data-bv-notempty-message=" ">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="grade">Grade</label>

                                            <div class="col-sm-5">
                                                <select class="form-control" id="grade" name="grade">
                                                    <option value="0">Normal</option>
                                                    <option value="1">Famous</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="col-sm-2 control-label">Order</label>

                                            <div class="col-sm-1">
                                                <input class="form-control" name="order">                                                
                                            </div>
                                        </div> -->
                                    </fieldset>
                                </div>
                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">  
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][designerId]" value="<?= $designerId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">

                                            <fieldset data-id="<?= $lrow->langId ?>">
                                                <legend>Designer Information</legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Designer Name</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control designer_name" name="langList[<?= $lrow->langId ?>][name]" data-bv-notempty="true" data-bv-notempty-message=" ">                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Country</label>

                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="langList[<?= $lrow->langId ?>][country]">
                                                            <?php $countryList = get_all_country();
                                                            foreach($countryList as $countryKey => $countryValue){ ?>
                                                                <option value="<?= $countryKey ?>"><?= $countryValue ?></option>
                                                            <?php } ?>  
                                                        </select>                                                      
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Description</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][description]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][content]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "></textarea>
                                                    </div>
                                                </div>

                                                <legend>Designer Story</legend>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][my_story_title]" data-bv-notempty="true" data-bv-notempty-message=" ">                                                                                                                
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Youtube</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][my_story_youtube]">                                                                                                                
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Story Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][my_story_content]" rows="10"></textarea>
                                                    </div>
                                                </div>

                                                <legend>Hometown</legend>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][hometown_title]" data-bv-notempty="true" data-bv-notempty-message=" ">                                                                                                                
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Content</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][hometown_content]" data-bv-notempty="true" data-bv-notempty-message=" ">                                                                                                                
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Country</label>

                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="langList[<?= $lrow->langId ?>][hometown_country]">
                                                            <?php $countryList = get_all_country();
                                                            foreach($countryList as $countryKey => $countryValue){ ?>
                                                                <option value="<?= $countryKey ?>"><?= $countryValue ?></option>
                                                            <?php } ?> 
                                                        </select>                                                       
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post1 Title</label>

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="langList[<?= $lrow->langId ?>][hometown_post1_title]" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>                                    

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post1 Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][hometown_post1_content]" rows="10"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post2 Title</label>

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="langList[<?= $lrow->langId ?>][hometown_post2_title]" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post2 Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][hometown_post2_content]" rows="10"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post3 Title</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="langList[<?= $lrow->langId ?>][hometown_post3_title]" data-bv-notempty="true" data-bv-notempty-message=" ">                                                   
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Hometown Post3 Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][hometown_post3_content]" rows="10"></textarea>
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
        $('input#uploadImg').change(function () {
            var $this = $(this);
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                $this.siblings('p:last').children('img#preview').attr('src', e.target.result).show();
            };
        });

        $("#save, #back").click(function (e) {            
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
                                    id:'<?= $designerId ?>',
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
                                    id:'<?= $designerId ?>',
                                    account: validator.getFieldElements('account').val()
                                };
                            },
                        }
                    }
                }
            }
        });
    });
</script>
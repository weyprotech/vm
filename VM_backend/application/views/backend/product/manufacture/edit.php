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

                    <h2>Manufacture</h2>
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
                            <input type="hidden" name="pId" value="<?= $pId ?>">
                            <input type="hidden" name="uuid" value="<?= $row->uuid ?>">
                            <input type="hidden" name="Id" value="<?= $row->Id ?>">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Manufacture</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">First Banner Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="firstbannerImg">

                                                <p class="help-block">
                                                    <strong>Note:</strong> Picture size is <strong>1920 x 582</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $firstbannerImg = check_file_path($row->firstbannerImg); ?>
                                                    <img id="preview" src="<?= $firstbannerImg ?>"<?= !$firstbannerImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Icon Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="iconImg">

                                                <p class="help-block">
                                                    <strong>Note:</strong> Picture size is <strong>80 x 80</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $iconImg = check_file_path($row->iconImg); ?>
                                                    <img id="preview" src="<?= $iconImg ?>"<?= !$iconImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Content1 Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="content1Img">

                                                <p class="help-block">
                                                    <strong>Note:</strong> Picture size is <strong>380 x 507</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $content1Img = check_file_path($row->content1Img); ?>
                                                    <img id="preview" src="<?= $content1Img ?>"<?= !$content1Img ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Content2 Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="content2Img">

                                                <p class="help-block">
                                                    <strong>Note:</strong> Picture size is <strong>380 x 507</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $content2Img = check_file_path($row->content2Img); ?>
                                                    <img id="preview" src="<?= $content2Img ?>"<?= !$content2Img ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Second Banner Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="secondbannerImg">

                                                <p class="help-block">
                                                    <strong>Note:</strong> Picture size is <strong>1920 x 582</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $secondbannerImg = check_file_path($row->secondbannerImg); ?>
                                                    <img id="preview" src="<?= $secondbannerImg ?>"<?= !$secondbannerImg ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Popup1 Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="popup1Img">

                                                <p class="help-block">
                                                    <strong>Note:</strong> Picture size is <strong>676 x 380</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $popup1Img = check_file_path($row->popup1Img); ?>
                                                    <img id="preview" src="<?= $popup1Img ?>"<?= !$popup1Img ? "display:none;" : "" ?>>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Popup1 Youtube</label>

                                            <div class="col-sm-9 col-lg-6">
                                                <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="popup1youtube" value="<?= @$row->popup1youtube ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Popup2 Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="popup2Img">

                                                <p class="help-block">
                                                    <strong>Note:</strong> Picture size is <strong>676 x 380</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $popup2Img = check_file_path($row->popup2Img); ?>
                                                    <img id="preview" src="<?= $popup2Img ?>"<?= !$popup2Img ? "display:none;" : "" ?>">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Popup2 Youtube</label>

                                            <div class="col-sm-9 col-lg-6">
                                                <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="popup2youtube" value="<?= @$row->popup2youtube ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Popup3 Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="popup3Img">

                                                <p class="help-block">
                                                    <strong>Note:</strong> Picture size is <strong>676 x 380</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $popup3Img = check_file_path($row->popup3Img); ?>
                                                    <img id="preview" src="<?= $popup3Img ?>"<?= !$popup3Img ? "display:none;" : "" ?>">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Popup3 Youtube</label>

                                            <div class="col-sm-9 col-lg-6">
                                                <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="popup3youtube" value="<?= @$row->popup3youtube ?>">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][mId]" value="<?= $row->Id ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">
                                            <fieldset>
                                                <legend><?= $lrow->name ?></legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Location</label>

                                                    <div class="col-sm-9 col-lg-4">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][location]" value="<?= @$row->langList[$lrow->langId]->location ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Content1 Title</label>

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][title1]" value="<?= @$row->langList[$lrow->langId]->title1 ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Content1 Detail</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][content1]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "><?= @$row->langList[$lrow->langId]->content1 ?></textarea>                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Content2 Title</label>

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][title2]" value="<?= @$row->langList[$lrow->langId]->title2 ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Content2 Detail</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][content2]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "><?= @$row->langList[$lrow->langId]->content2 ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Content3 Title</label>

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][title3]" value="<?= @$row->langList[$lrow->langId]->title3 ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Content3 Detail</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][content3]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "><?= @$row->langList[$lrow->langId]->content3 ?></textarea>                                                        
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save">Save</button>                                
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/product/product/". $this->query) ?>';">Return</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script src="<?= base_url("assets/backend/js/plugin/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/datatables/dataTables.tableTools.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/datatables/dataTables.bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/datatable-responsive/datatables.responsive.min.js") ?>"></script>
<link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/summernote.css") ?>">
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote-zh-TW.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/clockpicker/clockpicker.min.js") ?>"></script>
<script>
    var hash = window.location.hash;
    $('ul.nav-tabs li').eq(hash.substr(1)).addClass('active');
    $('.tab-pane').eq(hash.substr(1)).addClass('active');

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

        var responsiveHelper_dt_basic = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        $('form').bootstrapValidator({
            excluded: ""
        });
    });
</script>
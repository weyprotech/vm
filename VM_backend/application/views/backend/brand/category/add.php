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

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Category</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">visible</label>

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
                                            <label class="col-sm-2 control-label">icon</label>

                                            <div class="col-sm-9">
                                                <select class="form-control" id="store_icon" name="store_icon">
                                                    <option value="store_icon">Default</option>
                                                    <option value="store_icon_w">store_icon_w</option>
                                                    <option value="store_icon_s">store_icon_s</option>
                                                </select>
                                            </div>
                                            <br>
                                        </div>               
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"></label>

                                            <div class="col-sm-9">
                                                <img id="store_icon_show" src="<?= base_url('assets/backend/img/leaflet/store_marker.svg') ?>" style="width:50px;height:50px">
                                            </div>
                                            <br>
                                        </div>                                                   
                                    </fieldset>
                                </div>   
                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <?php $langData = @$row->langList[$lrow->langId]; ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">
                                            <fieldset>
                                                <legend><?= $lrow->name ?></legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Name</label>

                                                    <div class="col-sm-9 col-lg-4">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][name]" required>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>                           
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="back" onclick="$('#data-form').attr('action', '<?= $this->query . (!empty($this->query) ? '&' : '?') ?>back=1');">Return After Saving</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/brand/category/index/" . $this->query) ?>';">Return</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
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

        $('form').bootstrapValidator({
            excluded: ""
        });
    });

    $('#store_icon').on('change',function () {        
        switch($(this).val()){
            case 'store_icon':
                $('#store_icon_show').attr('src','<?= base_url('assets/backend/img/leaflet/store_marker.svg') ?>');
                break;
            case 'store_icon_w':
                $('#store_icon_show').attr('src','<?= base_url('assets/backend/img/leaflet/store_marker_w.svg') ?>');
                break;
            case 'store_icon_s':
                $('#store_icon_show').attr('src','<?= base_url('assets/backend/img/leaflet/store_marker_s.svg') ?>');
                break;
        }
    });
</script>
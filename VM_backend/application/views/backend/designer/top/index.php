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

                    <h2>Top Designer</h2>
                    <ul class="nav nav-tabs pull-right in"><?php $i = 1; ?>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>                        
                    </ul>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form id="data-form" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Top Designer</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">First</label>
                                            <input type="hidden" name="data[0][Id]" value=1>
                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" name="data[0][designerId]">
                                                    <?php foreach($designerList as $designerKey => $designerValue){ ?>
                                                        <option value="<?= $designerValue->designerId ?>" <?= $topList[0]->designerId == $designerValue->designerId ? 'selected' : '' ?>><?= $designerValue->name ?></option>
                                                    <?php } ?>
                                               </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Second</label>
                                            <input type="hidden" name="data[1][Id]" value=2>
                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" name="data[1][designerId]">
                                                    <?php foreach($designerList as $designerKey => $designerValue){ ?>
                                                        <option value="<?= $designerValue->designerId ?>" <?= $topList[1]->designerId == $designerValue->designerId ? 'selected' : '' ?>><?= $designerValue->name ?></option>
                                                    <?php } ?>
                                               </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Third</label>
                                            <input type="hidden" name="data[2][Id]" value=3>
                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" name="data[2][designerId]">
                                                    <?php foreach($designerList as $designerKey => $designerValue){ ?>
                                                        <option value="<?= $designerValue->designerId ?>" <?= $topList[2]->designerId == $designerValue->designerId ? 'selected' : '' ?>><?= $designerValue->name ?></option>
                                                    <?php } ?>
                                               </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Fourth</label>
                                            <input type="hidden" name="data[3][Id]" value=4>
                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" name="data[3][designerId]">
                                                    <?php foreach($designerList as $designerKey => $designerValue){ ?>
                                                        <option value="<?= $designerValue->designerId ?>" <?= $topList[3]->designerId == $designerValue->designerId ? 'selected' : '' ?>><?= $designerValue->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
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
    });
</script>
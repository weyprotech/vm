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

                    <h2>Delivery</h2>
                    <ul class="nav nav-tabs pull-right in"><?php $i = 1; ?>
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
                            <input type="hidden" name="Id" value="<?= $row->Id ?>">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][iId]" value="<?= $row->Id ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">
                                            <fieldset>
                                                <legend><?= $lrow->name ?></legend>
                                                <!-- <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][title]" value="<?= @$row->langList[$lrow->langId]->title ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>    -->
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Content</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][content]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "><?= @$row->langList[$lrow->langId]->content ?></textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save">Save</button>
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
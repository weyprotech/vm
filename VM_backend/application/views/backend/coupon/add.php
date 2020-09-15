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

                    <h2>Add Coupon</h2>                   
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
                                <fieldset>
                                    <legend>Coupon</legend>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="usable">Usable</label>
                                        <div class="col-sm-9">
                                            <label class="radio radio-inline">
                                                <input type="radio" class="radiobox" name="usable" value="1" checked>
                                                <span>Yes</span>
                                            </label>

                                            <label class="radio radio-inline">
                                                <input type="radio" class="radiobox" name="usable" value="0">
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="">Code</label>

                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" id="Code" name="Code" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="coupon_money">Coupon Money</label>

                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" id="coupon_money" name="coupon_money" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>
                                </fieldset>                               
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save">Save</button>
                                <button type="submit" class="btn btn-primary" id="back" onclick="$('#data-form').attr('action', '<?= $this->query . (!empty($this->query) ? '&' : '?') ?>back=1');">Return After Saving</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/coupon/coupon" . $this->query) ?>';">Return</button>
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
<script>
    var hash = window.location.hash;

    $(document).ready(function () {
        $("#save, #back").click(function (e) {
            
        });              

        var responsiveHelper_dt_basic = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };
    });

    $('form').bootstrapValidator({
        excluded: ""
    });    
</script>
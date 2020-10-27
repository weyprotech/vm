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
                    <ul class="nav nav-tabs pull-right in">
                        <li class="active"><a data-toggle="tab" href="#hb1">Gift</a></li>
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

                            <div id="content" class="tab-content">
                                <div class="tab-pane active" id="hb1">
                                    <fieldset>
                                        <legend>Gift information</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">OrderId</label>

                                            <div class="col-sm-5">
                                                <input class="form-control" type="text" value="<?= $row->Id ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Payment Type</label>

                                            <div class="col-sm-5">
                                                <input class="form-control" type="text" value="<?= $row->payment_type ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Date</label>

                                            <div class="col-sm-5">
                                                <input class="form-control" type="text" value="<?= $row->date ?>" readonly>
                                            </div>
                                        </div>
                                
                                        <legend>Gift Money</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Money(USD)</label>

                                            <div class="col-sm-5">
                                                <input class="form-control" type="text" value="<?= $row->money ?>" readonly>
                                            </div>
                                        </div>

                                        <legend>Payment</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Payment Status</label>

                                            <div class="col-sm-9 col-lg-8">
                                                <label class="radio radio-inline">
                                                    <?= $row->rtn_msg == '付款成功' ? 'Succeeded' : $row->rtn_msg ?>
                                                </label>                                                                                                                                    
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ecpay Order Number</label>

                                            <div class="col-sm-9 col-lg-8">
                                                <label class="radio radio-inline">
                                                    <?= $row->trade_no ?>
                                                </label>                                                                                                                                    
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Payment Type</label>

                                            <div class="col-sm-9 col-lg-8">
                                                <label class="radio radio-inline">
                                                    <?= $row->payment_type ?>
                                                </label>                                                                                                                                    
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Payment Date</label>

                                            <div class="col-sm-9 col-lg-8">
                                                <label class="radio radio-inline">
                                                    <?= $row->payment_date ?>
                                                </label>                                                                                                                                    
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Payment Virtual Account</label>

                                            <div class="col-sm-9 col-lg-8">
                                                <label class="radio radio-inline">
                                                    <?= $row->v_account ?>
                                                </label>                                                                                                                                    
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Payment Type Charge Fee</label>

                                            <div class="col-sm-9 col-lg-8">
                                                <label class="radio radio-inline">
                                                    <?= $row->payment_type_charge_fee ?>
                                                </label>                                                                                                                                    
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Trade Amount<br>(TWD)</label>

                                            <div class="col-sm-9 col-lg-8">
                                                <label class="radio radio-inline">
                                                    <?= $row->trade_amount ?>
                                                </label>                                                                                                                                    
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="widget-footer">                            
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/designer/gift" . $this->query) ?>';">Return</button>
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
<script>
    var hash = window.location.hash;
    $('ul.nav-tabs li').eq(hash.substr(1)).addClass('active');
    $('.tab-pane').eq(hash.substr(1)).addClass('active');
    $("input.datepicker").click(function(){
        $("#ui-datepicker-div").css('z-index','99');
    });
</script>
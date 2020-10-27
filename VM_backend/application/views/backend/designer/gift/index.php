<style>
    #content tr td {
        vertical-align: middle;
    }

    .dataTables_filter {
        float: none;
    }

    .category-select {
        padding-left: 5px;
        padding-bottom: 5px;
    }

    #preview img{
        width:120px;
    }

    .input-group{
        margin-left:5px;
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

            <div class="jarviswidget jarviswidget-color-darken" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false"
                 data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

                <header>
                    <span class="widget-icon"><i class="fa fa-table"></i></span>

                    <h2>Designer List</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table id="dt_basic" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th width="180" class="text-center">Id</th>
                                        <th width="120" class="text-center hidden-tablet">Icon</th>
                                        <th width="180" class="text-center hidden-tablet">Image</th>
                                        <th width="200" class="text-center">Name</th>
                                        <th width="150" class="text-center">Date</th>
                                        <th width="180" class="text-center">Money(USD)</th>
                                        <th width="180" class="text-center">Payment type charge fee(TWD)</th>
                                        <th width="200" class="text-center">Trade money(TWD)</th>
                                        <th width="200" class="text-center">Trade Number</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                </table>
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
    var $Table, $categorySelect;

    $(document).ready(function () {
        var responsiveHelper_dt_basic = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        $Table = $('#dt_basic').DataTable({
            "displayStart": <?= $start = check_input_value($this->input->get('start', true), true, 0) ?>,
            "pageLength": <?= $length = check_input_value($this->input->get('length', true), true, 25) ?>,
            "oSearch": {"sSearch": "<?= $this->input->get('search', true) ?>"},
            "autoWidth": false,
            "ordering": false,
            "serverSide": true,
            "sDom": "<'dt-toolbar'<'col-sm-7 hidden-xs' f<'dateFrom input-group hidden-tablet'><'dateTo input-group hidden-tablet'>><'col-xs-12 col-sm-5'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oTableTools": {
                "aButtons": []
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/designer/designer_gift/get_gift_data") ?>",
                "data": function (data) {
                    var startDate = $('div.dateFrom input').val();
                    data.startDate = startDate != undefined ? startDate : "<?= $this->input->get('startDate',true) ?>";

                    var endDate = $('div.dateTo input').val();
                    data.endDate = endDate != undefined ? endDate : "<?= $this->input->get('endDate',true) ?>";
                }
            },
            "columns": [
                {class: "", data:"giftId"},
                {class: "hidden-tablet", data:"icon"},
                {class: "hidden-tablet", data:"preview"},
                {class: "", data:"name"},      
                {class: "", data:"date"},
                {class: "", data:"money"},
                {class: "", data: "payment_type_charge_fee"},
                {class: "", data: "trade_money"},
                {class: "", data: "trade_no"},
                {class: "", data: "action"}
            ],
            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_dt_basic.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                responsiveHelper_dt_basic.respond();
            },
            "initComplete": function () {
                $dateFrom = $('div.dateFrom').html('<span class="input-group-addon">start Date</span><input type="text" class="form-control datepicker" id="startDate" data-dateformat="yy-mm-dd" placeholder="選擇日期" value="" style="width:100px">');
                $dateTo = $('div.dateTo').html('<span class="input-group-addon">end Date</span><input type="text" class="form-control datepicker" id="endDate" name="endDate" data-dateformat="yy-mm-dd" value="" placeholder="選擇日期" style="width:100px">');
                $('input.datepicker').datepicker({
                    dateFormat: 'yy-mm-dd'
                }).change(function() {
                    $Table.draw();
                });
            }
        });
    });
</script>
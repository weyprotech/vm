<style>
    #content tr td {
        vertical-align: middle;
    }


    #preview img {
        width: 100px;
        padding: 3px;
    }

    .dataTables_filter {
        float: none;
    }

    .main-select, .minor-select, .category-select{
        padding-left: 5px;
        padding-bottom: 5px;
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

                    <h2>Shipping List</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table id="dt_basic" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center hidden-xs">Usable</th>
                                            <th width="20%" class="text-center">Code</th>
                                            <th width="15%" class="text-center">Coupon money</th>
                                            <th width="15%" class="text-center">Action</th>
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
    $(document).ready(function () {
        var responsiveHelper_dt_basic = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        var $Table = $('#dt_basic').DataTable({
            "displayStart": <?= $start = check_input_value($this->input->get('start', true), true, 0) ?>,
            "pageLength": <?= $length = check_input_value($this->input->get('length', true), true, 25) ?>,
            "oSearch": {"sSearch": "<?= $this->input->get('search', true) ?>"},
            "autoWidth": false,
            "ordering": false,
            "serverSide": true,
            "sDom": "<'dt-toolbar'<'col-sm-9 hidden-xs' <'main-select input-group'><'minor-select input-group'><'category-select input-group'>><'col-xs-12 col-sm-3'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oTableTools": {
                "aButtons": [{
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span style="color:white">Add Coupon</span>',
                    "sButtonClass": "btn-lg btn-primary",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)');
                    },
                    "fnClick": function (nButton, oConfig, oFlash) {
                        $(nButton).attr('href', 'coupon/add/');                        
                    }
                }]
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/coupon/coupon/get_coupon_data") ?>",
                "data": function (data) {
                },
                "type":'post'
            },
            "columns": [
                {class: "hidden-xs", data: "usable"},
                {class: "", data: "code"},
                {class: "", data: "money"},
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

                $("div#preview").hover(
                    function () {
                        $(this).css("overflow", "visible").css("z-index", 99);
                    },
                    function () {
                        $(this).css("overflow", "hidden").css("z-index", 1);
                    }
                );
            },
            "initComplete": function () {                
            }
        });
    });
</script>
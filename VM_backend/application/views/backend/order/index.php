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

                    <h2>Order List</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table id="dt_basic" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th width="15%" class="text-center">OrderId</th>
                                            <th width="10%" class="text-center">Date</th>
                                            <th width="10%" class="text-center">Currency</th>
                                            <th width="10%" class="text-center">Total</th>
                                            <th width="10%" class="text-center">Status</th>
                                            <th width="10%" class="text-center">Country</th>
                                            <th width="10%" class="text-center">Name</th>
                                            <th width="10%" class="text-center">Phone</th>
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
        var status = {0:'Not paid yet',1:'Paid',2:'Delivered',3:'Finished'};
        var $Table = $('#dt_basic').DataTable({
            "displayStart": <?= $start = check_input_value($this->input->get('start', true), true, 0) ?>,
            "pageLength": <?= $length = check_input_value($this->input->get('length', true), true, 25) ?>,
            "oSearch": {"sSearch": "<?= $this->input->get('search', true) ?>"},
            "autoWidth": false,
            "ordering": false,
            "serverSide": true,
            "sDom": "<'dt-toolbar'<'col-sm-9 hidden-xs' f<'status-select input-group'><'payment_type-select input-group'><'dateFrom input-group hidden-tablet'><'dateTo input-group hidden-tablet'>><'col-xs-12 col-sm-3'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oTableTools": {
                "aButtons": [
                //     {
                //     "sExtends": "text",
                //     "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span style="color:white">Add Order</span>',
                //     "sButtonClass": "btn-lg btn-primary",
                //     "fnInit": function (nButton, oConfig) {
                //         $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)');
                //     },
                //     "fnClick": function (nButton, oConfig, oFlash) {
                //         $(nButton).attr('href', 'order/add/');                        
                //     }
                // }
                ]
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/order/order/get_order_data") ?>",
                "data": function (data) {
                    data.page = '<?= $page ?>';

                    var status = $('div.status-select select').val();
                    data.status = status != undefined ? status : '<?= $this->input->get('status',true) ?>';

                    var startDate = $('div.dateFrom input').val();
                    data.startDate = startDate != undefined ? startDate : "<?= $this->input->get('startDate',true) ?>";

                    var endDate = $('div.dateTo input').val();
                    data.endDate = endDate != undefined ? endDate : "<?= $this->input->get('endDate',true) ?>";
                },
                "type":'post'
            },
            "columns": [
                {class: "", data: "orderid"},
                {class: "", data: "date"},
                {class: "", data: "currency"},
                {class: "", data: "total"},
                {class: "", data: "status"},
                {class: "", data: "country"},
                {class: "", data: "name"},
                {class: "", data: "phone"},
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
                $status = $('div.status-select').html('<span class="input-group-addon">Status</span><select class="form-control"></select>')
                    .find('select').html('<option value="">All</option>').change(function () {
                        $Table.draw();
                    });
                option_init($status,status);
            }
        });
    });

    function option_init(select,option){
        $.each(option,function(index,value){
            select.append('<option value="'+index+'">'+value+'</option>');
        });
    }
</script>
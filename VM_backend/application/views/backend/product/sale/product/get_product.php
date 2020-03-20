<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/bootstrap.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/font-awesome.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/smartadmin-production-plugins.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/smartadmin-production.min.css") ?>">
    <link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/smartadmin-skins.min.css") ?>">
    <script src="<?= base_url("assets/backend/js/libs/jquery-2.1.1.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/promise.min.js") ?>"></script>
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
</head>
<body>
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

            <h2>Product List</h2>
        </header>

        <div>
            <div class="widget-body no-padding">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table id="dt_basic" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center hidden-xs">Visible</th>
                                    <th width="12%" class="text-center hidden-tablet hidden-md">Image</th>
                                    <th width="12%" class="text-center">Name</th>
                                    <th width="15%" class="text-center">Base Category</th>
                                    <th width="15%" class="text-center">Sub Category</th>
                                    <th width="15%" class="text-center">Category</th>
                                    <th width="160" class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="<?= base_url("assets/backend/js/plugin/datatables/jquery.dataTables.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/datatables/dataTables.tableTools.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/datatables/dataTables.bootstrap.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/datatable-responsive/datatables.responsive.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/pace/pace.min.js") ?>" data-pace-options='{ "restartOnRequestAfter": true }'></script>
    <script src="<?= base_url("assets/backend/js/libs/jquery-ui-1.10.3.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/app.config.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/bootstrap/bootstrap.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/notification/SmartNotification.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/smartwidgets/jarvis.widget.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/sparkline/jquery.sparkline.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/jquery-validate/jquery.validate.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/masked-input/jquery.maskedinput.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/select2/select2.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/bootstrap-slider/bootstrap-slider.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/msie-fix/jquery.mb.browser.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/plugin/fastclick/fastclick.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/app.min.js") ?>"></script>
    <script src="<?= base_url("assets/backend/js/speech/voicecommand.min.js") ?>"></script>
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
                "sDom": "<'dt-toolbar'<'col-sm-9 hidden-xs' f<'main-select input-group'><'minor-select input-group'><'category-select input-group'>><'col-xs-12 col-sm-3'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "oTableTools": {
                    "aButtons": []
                },
                "ajax": {
                    "url": "<?= site_url("backend/ajax/product/sale/sale/get_product_data") ?>",
                    "data": function (data) {
                        data.baseId = $('#dialog').find('div.main-select select').val();
                        data.subId = $('#dialog').find('div.minor-select select').val();
                        data.categoryId = $('#dialog').find('div.category-select select').val();
                    },
                    "type":'post'
                },
                "columns": [
                    {class: "hidden-xs", data: "visible"},
                    {class: "hidden-tablet hidden-md", data: "preview"},
                    {class: "", data: "name"},
                    {class: "", data: "base_category"},
                    {class: "", data: "sub_category"},
                    {class: "", data: "category"},
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
                    $categorySelect = $('div.main-select').html('<span class="input-group-addon">Base Category</span><select class="form-control"></select>')
                    .find('select').html("<option value=''>All</option>").change(function(){
                        var category = $(this).val();                    
                        get_area_option(category).done(function(response){                                                
                            $areaList.html(response['option']);
                            $('div.minor-select select').val('0');
                            $('div.category-select select').val('0');
                        });
                        $Table.draw();

                    });               

                    get_category_option('<?= $this->input->get('cId', true) ?>').done(function (respone) {
                        $categorySelect.append(respone['option']);
                    });

                    $areaList = $('div.minor-select').html('<span class="input-group-addon">Sub Category</span><select class="form-control"></select>')
                        .find('select').html('<option value="">All</option>').change(function(){
                            var category2 = $(this).val();                    
                            get_area_option(category2).done(function(response){
                                $category3.html(response['option']);
                                $('div.category-select select').val('0');
                            });
                            $Table.draw();

                        });

                    get_area_option('<?= $this->input->get('cId', true) ?>').done(function(response){                       
                        $areaList.html(response['option']);
                    });

                    $category3 = $('div.category-select').html('<span class="input-group-addon">Category</span><select class="form-control"></select>')
                        .find('select').html('').change(function(){                   
                            $Table.draw();
                        });
                }
            });
        });

        function get_category_option(selectId) {
            return $.ajax({
                url: '<?= site_url('backend/ajax/product/category/get_first_option') ?>',
                data: {selectId: selectId},
                type: 'get',
                dataType: 'json'
            });
        }

        function get_area_option(category){
            return $.ajax({
                url:'<?= site_url('backend/ajax/product/category/get_category_option') ?>',
                type:'get',
                data:{selected : '',cId : category},
                dataType:'json',
            });
        }
    </script>
</body>
</html>
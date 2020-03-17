<style>
    #content tr td {
        vertical-align: middle;
    }

    #preview {
        width: 100%;
        height: 30px;
        overflow: hidden;
        position: relative;
    }

    #preview img {
        width: 100%;
        padding: 3px;
        margin: -50% 0;
        background-color: white;
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
                                            <th width="20%" class="text-center hidden-tablet hidden-md">Image</th>
                                            <th class="text-center">Name</th>
                                            <th width="10%" class="text-center">Base Category</th>
                                            <th width="10%" class="text-center">Category</th>
                                            <th width="70" class="text-center hidden-tablet">Sort</th>
                                            <th width="140" class="text-center">Action</th>
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
            "sDom": "<'dt-toolbar'<'col-sm-9 hidden-xs' f<'main-select input-group'><'minor-select input-group'><'category-select input-group'>><'col-xs-12 col-sm-3'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oTableTools": {
                "aButtons": [{
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span class="hidden-mobile" style="color:white">Update Sort</span>',
                    "sButtonClass": "btn-lg hidden-tablet btn-success",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)');
                    },
                    "fnClick": function (nButton, oConfig, oFlash) {
                        $(nButton).parents('form:first').attr('action', 'category/save').submit();
                    }
                }, {
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span style="color:white">Add Product</span>',
                    "sButtonClass": "btn-lg btn-primary",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)');
                    },
                    "fnClick": function (nButton, oConfig, oFlash) {
                        $(nButton).attr('href', 'product/add/');                        
                    }
                }]
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/product/product/get_product_data") ?>",
                "data": function (data) {
                    data.mainId = $('div.main-select select').val();
                    data.minorId = $('div.minor-select select').val();
                }
            },
            "columns": [
                {class: "hidden-xs", data: "visible"},
                {class: "hidden-tablet hidden-md", data: "preview"},
                {class: "", data: "name"},
                {class: "", data: "base_category"},
                {class: "", data: "sub_category"},
                {class: "hidden-tablet", data: "order"},
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
                .find('select').html("<option value=''>全部</option>").change(function(){
                    var category = $(this).val();                    
                    $Table.draw();
                    get_area_option(category).done(function(response){                                                
                        $areaList.html(response['option']);
                    });
                });               

                get_category_option('<?= $this->input->get('cId', true) ?>').done(function (respone) {
                    $categorySelect.append(respone['option']);
                });

                $areaList = $('div.minor-select').html('<span class="input-group-addon">Sub Category</span><select class="form-control"></select>')
                    .find('select').html('<option value="">全部</option>').change(function(){
                        var category2 = $(this).val();                    
                        $Table.draw();
                        get_area_option(category2).done(function(response){
                            $category3.html(response['option']);
                        });
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
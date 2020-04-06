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

    .category-select, .area-select{
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

                    <h2>Category List</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table id="dt_basic" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th width="30" class="text-center hidden-xs">Visible</th>
                                        <th class="text-center">Title</th>
                                        <th width="10%" class="text-center hidden-tablet hidden-md">Base Category</th>
                                        <th width="10%" class="text-center">Sub Category</th>
                                        <th width="70" class="text-center hidden-tablet">Sort</th>
                                        <th width="180" class="text-center">Action</th>
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
        var secondId;
        var prevId = '<?= check_input_value($this->input->get('prevId', true), true, 0) ?>';
        var $Table = $('#dt_basic').DataTable({
            "displayStart": <?= $start = check_input_value($this->input->get('start', true), true, 0) ?>,
            "pageLength": <?= $length = check_input_value($this->input->get('length', true), true, 25) ?>,
            "oSearch": {"sSearch": "<?= $this->input->get('search', true) ?>"},
            "autoWidth": false,
            "ordering": false,
            "serverSide": true,
            "sDom": "<'dt-toolbar'<'col-sm-8 hidden-xs' f<'category-select input-group hidden-tablet'><'area-select input-group hidden-tablet'>><'col-xs-12 col-sm-4'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oTableTools": {
                "aButtons": [{
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-refresh" style="color:white"></i> <span class="hidden-mobile" style="color:white">Update Sort</span>',
                    "sButtonClass": "btn-lg btn-success hidden-tablet",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)');
                    },
                    "fnClick": function (nButton, oConfig, oFlash) {
                        $(nButton).parents('form:first').attr('action', 'category/save').submit();
                    }
                }, {
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span style="color:white">Add Category</span>',
                    "sButtonClass": "btn-lg btn-primary",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)');
                    },
                    "fnClick": function (nButton, oConfig) {
                        $(nButton).attr('href', 'category/add/' + prevId);
                    }
                }]
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/product/category/get_category_data") ?>",
                "data": function (data) {
                    var firstId = $('div.category-select select').val();
                    data.firstId = firstId != undefined ? firstId : '<?= $this->input->get('firstId', true) ?>';
                    secondId = $('div.area-select select').val();
                    data.secondId = secondId != undefined ? secondId : '<?= $this->input->get('secondId',true) ?>';
                }
            },
            "columns": [
                {class: "hidden-xs", data: "visible"},
                {class: "", data: "name"},
                {class: "hidden-tablet hidden-md", data: "base_category"},
                {class: "hidden-tablet hidden-md", data: "sub_category"},
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
                $categorySelect = $('div.category-select').html('<span class="input-group-addon">Base Category</span><select class="form-control"></select>')
                    .find("select").html("<option value=''>None</option><option value='all'>All</option>").change(function () {
                        var category = $(this).val();
                        var result = '';
                        $Table.draw();
                        get_area_option(category,secondId).done(function(response){    
                            result += '';
                            result += response['option'];

                            $areaList.html(result);
                        });
                    }).trigger("change");

                get_category_option('<?= $this->input->get('firstId', true) ?>').done(function (respone) {
                    $categorySelect.append(respone['option']);                    
                });

                $areaList = $('div.area-select').html('<span class="input-group-addon">Sub Category</span><select class="form-control"></select>')
                    .find('select').html('<option value="">None</option>').change(function(){
                        $Table.draw();
                    });

                get_area_option('<?= $this->input->get('firstId', true) ?>','<?= $this->input->get('secondId', true) ?>').done(function(response){   
                    result = '';
                    result += response['option'];
                    $areaList.html(result);
                });
            }
        });

        function get_category_option(selectId) {
            return $.ajax({
                url: '<?= site_url('backend/ajax/product/category/get_first_option') ?>',
                data: {selectId: selectId},
                type: 'get',
                dataType: 'json'
            });
        }

        function get_area_option(category,selectId){
            return $.ajax({
                url:'<?= site_url('backend/ajax/product/category/get_category_option') ?>',
                type:'get',
                data:{selected : selectId,cId : category},
                dataType:'json',
            });
        }
    });
</script>
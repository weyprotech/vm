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
<div id="dialog" style="display: none;"></div>

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

                    <h2>Sale Product List</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table id="dt_basic_sale" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th width="10%" class="text-center hidden-tablet hidden-md">Image</th>
                                            <th width="20%" class="text-center">Name</th>
                                            <th width="15%" class="text-center">Base Category</th>
                                            <th width="15%" class="text-center">Sub Category</th>
                                            <th width="15%" class="text-center">Category</th>
                                            <th width="100" class="text-center">Original Price</th>
                                            <th width="100" class="text-center">Special Offer</th>
                                            <th width="160" class="text-center">Action</th>
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
    //選擇訂單
    $("body").on("click", ".dialog", function () {
        var url = $(this).attr("href");
        $('#dialog').html("");
        var dialog = $('#dialog').dialog({
            modal: true,
            draggable: false,
            resizable: false,
            width: $("#content").width(),
            position: { my: 'top', at: 'top+10' },
            open: function (event, ui) {
                $(this).load(url);
            }
        });
        swal.close();
        
        dialog.dialog('open');
        return false;
    });
    var $Table;
    $(document).ready(function () {
        var responsiveHelper_dt_basic = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        $Table = $('#dt_basic_sale').DataTable({
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
                    "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span style="color:white">Add Sale Product</span>',
                    "sButtonClass": "btn-lg btn-primary dialog",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)').attr('href', 'sale_product/get_product/');
                        // .attr('href', 'sale_product/get_product/').attr('data-toggle','modal');
                    },
                    "fnClick": function (nButton, oConfig, oFlash) {
                    }
                }]
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/product/sale/sale/get_sale_product") ?>",
                "data": function (data) {
                    data.baseId = $('div.main-select select').val();
                    data.subId = $('div.minor-select select').val();
                    data.categoryId = $('div.category-select select').val();
                },
                "type":'post'
            },
            "columns": [
                {class: "hidden-tablet hidden-md", data: "preview"},
                {class: "", data: "name"},
                {class: "", data: "base_category"},
                {class: "", data: "sub_category"},
                {class: "", data: "category"},
                {class: "", data: "original_price"},
                {class: "", data: "special_offer"},
                {class: "", data: "action"}
            ],
            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic_sale'), breakpointDefinition);
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

    //選擇產品
    function select_product(productId){
        $.ajax({
            url:'<?= site_url('backend/ajax/product/sale/sale/add_product') ?>',
            type:'post',
            data:{productId : productId},
            dataType:'post',
            success:function(response){
                
            }
        });
        $('.ui-dialog-titlebar-close').click();
        // $Table.draw();
        window.location.reload();
    }
</script>
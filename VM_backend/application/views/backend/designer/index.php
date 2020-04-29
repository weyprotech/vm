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
                                        <th width="30" class="text-center">Visible</th>
                                        <th width="120" class="text-center hidden-tablet">Icon</th>
                                        <th width="180" class="text-center hidden-tablet">Image</th>
                                        <th width="200" class="text-center">Name</th>
                                        <th width="60" class="text-center hidden-tablet">Sort</th>
                                        <th width="20" class="text-center">Banner</th>
                                        <th width="20" class="text-center">Post</th>
                                        <th width="40" class="text-center">Runway New Event</th>
                                        <th width="40" class="text-center">Just for you</th>
                                        <th width="40" class="text-center">Message</th>
                                        <th width="40" class="text-center">Review</th>
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
            "sDom": "<'dt-toolbar'<'col-sm-7 hidden-xs' f<'country-select input-group'>><'col-xs-12 col-sm-5'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oTableTools": {
                "aButtons": [{
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span class="hidden-mobile" style="color:white">Update Sort</span>',
                    "sButtonClass": "btn-lg hidden-tablet btn-success",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)');
                    },
                    "fnClick": function (nButton, oConfig, oFlash) {
                        $(nButton).parents('form:first').attr('action', 'designer/save').submit();
                    }
                },{
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span class="hidden-mobile" style="color:white">Add Designer</span>',
                    "sButtonClass": "btn-lg btn-primary",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).attr('href', '<?= site_url(uri_string() . "/add") ?>').css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)');
                    }
                }]
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/designer/designer/get_designer_data") ?>",
                "data": function (data) {
                    var country = $('div.country-select select').val();
                    data.country = country != undefined ? country : '<?= $this->input->get('country', true) ?>';
                }
            },
            "columns": [
                {class: "", data:"visible"},
                {class: "hidden-tablet", data:"icon"},
                {class: "hidden-tablet", data:"preview"},
                {class: "", data:"name"},
                {class: "hidden-tablet", data: "order"},                
                {class: "", data:"banner"},
                {class: "", data:"post"},
                {class: "", data: "runway"},
                {class: "", data: "just_for_you"},
                {class: "", data: "message"},
                {class: "", data: "review"},
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
                $countrySelect = $('div.country-select').html('<span class="input-group-addon">Country</span><select class="form-control"></select>')
                    .find("select").html("<option value=''>All</option>").change(function () {
                        $Table.draw();
                    });

                get_country_option('<?= $this->input->get('countryId', true) ?>').done(function (respone) {
                    $countrySelect.append(respone['option']);
                });
            }
        });
    });

    function get_country_option(selectId) {
        return $.ajax({
            url: '<?= site_url('backend/ajax/designer/designer/get_country_option') ?>',
            data: {selectId: selectId},
            type: 'get',
            dataType: 'json'
        });
    }
</script>
<style>
    #content tr td {
        vertical-align: middle;
    }

    .dataTables_filter {
        float: none;
    }

    .group-select {
        padding-left: 5px;
        padding-bottom: 5px;
    }
</style>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php if ($active = get_cookie('active')) { ?>
                <div class="alert alert-<?= $active['status'] ?> alert-block">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><?= $active['message'] ?></h4>
                </div>
                <?php 
            } ?>

            <div class="jarviswidget jarviswidget-color-darken" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false"
                 data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

                <header>
                    <span class="widget-icon"><i class="fa fa-table"></i></span>

                    <h2>Manager List</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
                            <table id="dt_basic" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th width="30" class="text-center hidden-mobile">Enable</th>
                                    <th class="text-center">Name</th>
                                    <th width="200" class="text-center hidden-xs">Group</th>
                                    <th width="140" class="text-center">Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
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
            "autoWidth": false,
            "ordering": false,
            "serverSide": true,
            "sDom": "<'dt-toolbar'<'col-sm-7 hidden-xs' f<'group-select input-group'>><'col-xs-12 col-sm-5'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oTableTools": {
                "aButtons": [{
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-plus"></i> <span class="hidden-mobile">Add Manager</span>',
                    "sButtonClass": "btn-lg",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).attr('href', '<?= site_url(uri_string() . "/add") ?>');
                    }
                }]
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/admin/get_user_data") ?>",
                "data": function (data) {
                    data.gId = $('div.group-select select').val();
                }
            },
            "columns": [
                {class: "hidden-mobile", data: "visible"},
                {class: "", data: "name"},
                {class: "hidden-xs", data: "groupName"},
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
                $('div.group-select').html('<span class="input-group-addon">Group</span><select class="form-control"></select>')
                    .find('select').change(function () {
                    $Table.draw();
                    });

                $.ajax({
                    url: '<?= site_url('backend/ajax/admin/get_group_option') ?>',
                    success: function (option) {
                        $('div.group-select select').html(option);
                    }
                })
            }
        });
    });
</script>
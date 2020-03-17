<style>
    #content tr td {
        vertical-align: middle;
    }
</style>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12">
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
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>

                    <h2>Group List</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="widget-body-toolbar">
                                <div class="row">
                                    <div class="col-xs-6 text-left">
                                        <button type="button" class="btn btn-success hidden-mobile" id="reorder" data-href="group/save">
                                            <i class="fa fa-refresh"></i> <span>Update Sort</span>
                                        </button>
                                    </div>

                                    <div class="col-xs-6 text-right">
                                        <a class="btn btn-primary" href="<?= site_url(uri_string() . '/add') ?>">
                                            <i class="fa fa-plus"></i> <span>Add Group</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="dt_basic" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th width="100" class="text-center hidden-mobile">Sort</th>
                                        <th width="160" class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="group-list">
                                    <?php if ($groupList) {
                                        foreach ($groupList as $grow) { ?>
                                            <tr>
                                                <td><?= $grow->name ?></td>
                                                <td class="hidden-mobile">
                                                    <input type="hidden" name="groupOrder[<?= $grow->groupId ?>][groupId]" value="<?= $grow->groupId ?>">
                                                    <input type="text" class="form-control text-center" name="groupOrder[<?= $grow->groupId ?>][order]" value="<?= $grow->order ?>">
                                                </td>
                                                <td>
                                                    <a class="btn btn-default" href="<?= site_url(uri_string() . '/edit/' . $grow->groupId) ?>">
                                                        <i class="fa fa-gear"></i><span class="hidden-tablet"> Edit </span>
                                                    </a>
                                                    <a class="btn btn-danger" href="<?= site_url(uri_string() . '/delete/' . $grow->groupId) ?>" onclick="return confirm('Are you sure?');">
                                                        <i class="glyphicon glyphicon-trash"></i><span class="hidden-tablet"> Delete </span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php 
                                        }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#reorder').click(function () {
            $(this).parents('form:first').attr('action', $(this).data('href')).submit();
        });
    });
</script>
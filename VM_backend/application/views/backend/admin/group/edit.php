<style>
    .onoffswitch {
        margin-right: 25px;
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

            <div class="jarviswidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false"
                 data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>

                    <h2>Edit</h2>
                    <ul class="nav nav-tabs pull-right"><?php $i = 1; ?>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Permission</a></li>
                    </ul>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form id="data-form" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="uuid" value="<?= $row->uuid ?>">
                            <input type="hidden" name="is_enable" value="1">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Content</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Name</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <input type="text" class="form-control" name="name" value="<?= $row->name ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Sort</label>

                                            <div class="col-sm-2">
                                                <input class="form-control" type="number" name="order" value="<?= $row->order ?>" min="1">

                                                <p class="help-block"><strong>Note:</strong> put the numbers in descending order</p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Permission</legend>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <ol class="dd-list" id="auth-list">
                                                    <?= $authList ?>
                                                </ol>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save">Save</button>
                                <button type="submit" class="btn btn-primary" id="back" onclick="$('#data-form').attr('action', '?back=1');">Return After Saving</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url('backend/admin/group') ?>';">Return</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script>
    var hash = window.location.hash;
    $('ul.nav-tabs li').eq(hash.substr(1)).addClass('active');
    $('.tab-pane').eq(hash.substr(1)).addClass('active');

    $(document).ready(function () {
        $('#auth-list').find('label input:checkbox').change(function (e) {
            var checkbox_id = $(this).attr('id');
            var value = $(this).prop('checked');
            var boolean = $(this).parents('label[for="' + checkbox_id + '"]').is(function () {
                return $(this).parent('div').children('label:first').attr('for') === checkbox_id;
            });

            if (value) {
                $(this).parents('li.dd-item').find('label:first input:checkbox').prop('checked', value);
            }

            if (boolean) {
                $(this).parents('li.dd-item:first').find('label input:checkbox').prop('checked', value);
            }
        });
    });
</script>
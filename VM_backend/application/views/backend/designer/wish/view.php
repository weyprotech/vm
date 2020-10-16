<style type="text/css">
    .help-block #preview {
        width: auto;
        max-width: 90%;
        max-height: 300px;
        margin-bottom: 6px;
        padding: 3px;
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

            <div class="jarviswidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false"
                 data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>

                    <h2>View</h2>
                    <ul class="nav nav-tabs pull-right in"><?php $i = 1; ?>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>                        
                    </ul>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <div id="content" class="tab-content"><?php $i = 1; ?>
                            <div class="tab-pane" id="hb<?= $i++ ?>">
                                <fieldset>
                                    <legend>Review</legend>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="product">Name</label>

                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="product" value="<?= @$name ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="title">Title</label>

                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="title" value="<?= @$row->title ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Content</label>

                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="10" readonly><?= @$row->content ?></textarea>                                                
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="widget-footer">                                
                            <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/designer/wish/index/".$designerId . $this->query) ?>';">Return</button>
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
<link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/summernote.css") ?>">
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote-zh-TW.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/clockpicker/clockpicker.min.js") ?>"></script>
<script>
    var hash = window.location.hash;
    $('ul.nav-tabs li').eq(hash.substr(1)).addClass('active');
    $('.tab-pane').eq(hash.substr(1)).addClass('active');
</script>
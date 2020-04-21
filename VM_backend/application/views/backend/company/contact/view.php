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

                    <h2>Edit</h2>
                    <ul class="nav nav-tabs pull-right in"><?php $i = 1; ?>
                        <li class="active"><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>
                    </ul>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form id="data-form" class="form-horizontal" method="post" enctype="multipart/form-data"
                            data-bv-message="This value is not valid"
                            data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                            data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                            data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                            <input type="hidden" name="is_enable" value="1">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane active" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Contact</legend>                                        

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="name">Name</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" value="<?= $row->name ?>" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="email">Email</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="email" value="<?= $row->email ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="phone_area_code">Phone Area Code</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="phone_area_code" value="<?= $row->phone_area_code ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="phone">Phone</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="phone" value="<?= $row->phone ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="topic">Topic</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="topic" value="<?= $row->topic ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="contact_type">Contact me</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="contact_type" value="<?= $row->contact_type == 0 ? 'email' : 'phone'  ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="comments">Comments</label>

                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="10" readonly><?= $row->comments ?></textarea>                                               
                                            </div>
                                        </div>                                        
                                    </fieldset>
                                </div>
                            </div>

                            <div class="widget-footer">
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/company/contact" . $this->query) ?>';">Return</button>
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
        $('form').bootstrapValidator({
            excluded: ""
        });     
    });
</script>
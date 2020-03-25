<style type="text/css">
    #preview {
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

                    <h2>編輯</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form id="data_form" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="uuid" value="<?= $row->uuid ?>">
                            <input type="hidden" name="is_enable" value="1">

                            <div id="content">
                                <fieldset>
                                    <legend>產品圖</legend>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="name">名稱</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="text" id="name" name="name" value="<?= $row->name ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">產品圖</label>

                                        <div class="col-sm-9">
                                            <input type="file" class="btn btn-default" id="uploadImg" name="photoImg">

                                            <p class="help-block">
                                                <strong>Note:</strong> type is<strong>JPG、PNG</strong>。
                                            </p>

                                            <p class="help-block">
                                                <?php $imagePath = check_file_path($row->imagePath); ?>
                                                <img id="preview" src="<?= $imagePath ?>" <?= !$imagePath ? "style=\"display:none;\"" : "" ?>>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- 如果不需要另外上傳縮圖，以下可不使用 -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">產品縮圖</label>

                                        <div class="col-sm-9">
                                            <input type="file" class="btn btn-default" id="uploadImg" name="thumbImg">

                                            <p class="help-block">
                                                <strong>Note:</strong> 建議上傳圖片尺寸為 <strong>300 x 200</strong> .type is<strong>JPG、PNG</strong> 。
                                            </p>

                                            <p class="help-block">
                                                <?php $thumbPath = check_file_path($row->thumbPath); ?>
                                                <img id="preview" src="<?= $thumbPath ?>" <?= !$thumbPath ? "style=\"display:none;\"" : "" ?>>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">排序</label>

                                        <div class="col-sm-2">
                                            <input class="form-control" type="number" name="order" value="<?= $row->order ?>" min="1">

                                            <p class="help-block"><strong>Note:</strong> put the numbers in descending order</p>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save">儲存</button>
                                <button type="submit" class="btn btn-primary" id="back" onclick="$('#data_form').attr('action', '<?= $this->query . (!empty($this->query) ? '&' : '?') ?>back=1#3');">儲存後返回</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url('backend/product/edit/' . $row->prevId . $this->query) ?>#3';">返回</button>
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
        $('input#uploadImg').change(function () {
            $this = $(this);
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                $this.siblings('p:last').children('img#preview').attr('src', e.target.result).show();
            }
        });
    });
</script>
<style type="text/css">
    #content tr td {
        vertical-align: middle;
    }

    .help-block #preview {
        width: auto;
        max-width: 90%;
        max-height: 300px;
        margin-bottom: 6px;
        padding: 3px;
    }

    div#preview {
        width: 100%;
        height: 30px;
        overflow: hidden;
        position: relative;
    }

    div#preview img {
        width: 100%;
        padding: 3px;
        margin: -100% 0;
        background-color: white;
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
                    <ul class="nav nav-tabs pull-right in"><?php $i = 1; ?>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">基本資料</a></li>
                        <?php if ($this->langList): ?>
                            <?php foreach ($this->langList as $lrow): ?>
                                <li><a data-toggle="tab" href="#hb<?= $i++ ?>"><?= $lrow->name ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">圖片列表</a></li>
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
                                        <legend>產品</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">顯示</label>

                                            <div class="col-sm-9">
                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox" name="is_visible" value="1" <?= $row->is_visible ? "checked" : "" ?>>
                                                    <span>是</span>
                                                </label>

                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox" name="is_visible" value="0" <?= !$row->is_visible ? "checked" : "" ?>>
                                                    <span>否</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="mainId">類別</label>

                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-xs-6 col-lg-4 main-select"></div>
                                                    <div class="col-xs-6 col-lg-4 minor-select"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">代表圖</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="productImg">

                                                <p class="help-block">
                                                    <strong>Note:</strong> 建議上傳圖片大小為 <strong>300 x 200</strong>.type is<strong>JPG、PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <?php $productImg = check_file_path($row->productImg); ?>
                                                    <img id="preview" src="<?= $productImg ?>"<?= !$productImg ? "display:none;" : "" ?>">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="order">排序</label>

                                            <div class="col-sm-2">
                                                <input class="form-control" type="number" id="order" name="order" value="<?= $row->order ?>" min="1">

                                                <p class="help-block"><strong>Note:</strong> put the numbers in descending order</p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <?php $langData = @$row->langList[$lrow->langId]; ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][pId]" value="<?= $row->productId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">
                                            <fieldset>
                                                <legend><?= $lrow->name ?></legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">名稱</label>

                                                    <div class="col-sm-9 col-lg-4">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][name]" value="<?= @$langData->name ?>" required>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <section id="widget-grid" class="">
                                        <div class="row">
                                            <article class="col-xs-12">
                                                <div class="jarviswidget jarviswidget-color-darken" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false"
                                                     data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

                                                    <header>
                                                        <span class="widget-icon"><i class="fa fa-table"></i></span>

                                                        <h2>圖片 列表</h2>
                                                    </header>

                                                    <div>
                                                        <div class="widget-body no-padding">
                                                            <div class="widget-body-toolbar">
                                                                <div class="row">
                                                                    <div class="col-xs-6 text-left">
                                                                        <button type="submit" class="btn btn-success hidden-mobile" formaction="../image/save/<?= $row->productId . $this->query ?>">
                                                                            <i class="fa fa-refresh"></i> <span>更新排序</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-xs-6 text-right">
                                                                        <a class="btn btn-primary" href="<?= site_url("backend/product/image/add/" . $row->productId . $this->query) ?>">
                                                                            <i class="fa fa-plus"></i> <span>新增圖片</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="table-responsive">
                                                                <table id="dt_basic" class="table table-bordered table-striped text-center">
                                                                    <thead>
                                                                    <tr>
                                                                        <th width="50" class="text-center hidden-xs">顯示</th>
                                                                        <th width="20%" class="text-center hidden-tablet hidden-md">預覽</th>
                                                                        <th class="text-center">名稱</th>
                                                                        <th width="100" class="text-center hidden-tablet">排序</th>
                                                                        <th width="160" class="text-center">功能</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php if ($imageList): ?>
                                                                        <?php foreach ($imageList as $irow): ?>
                                                                            <tr>
                                                                                <td><img src="<?= show_enable_image($irow->is_visible) ?>" width="25"></td>
                                                                                <td class="hidden-tablet hidden-md">
                                                                                    <div id="preview">
                                                                                        <?php if (!empty($irow->thumbPath)): ?>
                                                                                            <img src="<?= base_url($irow->thumbPath) ?>"/>
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                </td>
                                                                                <td><?= $irow->name ?></td>
                                                                                <td class="hidden-tablet">
                                                                                    <input type="hidden" name="imageOrder[<?= $irow->imageId ?>][imageId]" value="<?= $irow->imageId ?>">
                                                                                    <input type="text" class="form-control text-center" name="imageOrder[<?= $irow->imageId ?>][order]" value="<?= $irow->order ?>" style="width: 100%;">
                                                                                </td>
                                                                                <td>
                                                                                    <a href="<?= site_url("backend/product/image/edit/" . $irow->imageId . $this->query) ?>" class="btn btn-default">
                                                                                        <i class="fa fa-gear"></i><span class="hidden-tablet"> 編輯 </span>
                                                                                    </a>
                                                                                    <a href="<?= site_url("backend/product/image/delete/" . $irow->imageId . $this->query) ?>" class="btn btn-danger" onclick="return confirm('確定要刪除?');">
                                                                                        <i class="glyphicon glyphicon-trash"></i><span class="hidden-tablet"> 刪除 </span>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save">儲存</button>
                                <button type="submit" class="btn btn-primary" id="back" onclick="$('#data-form').attr('action', '<?= $this->query . (!empty($this->query) ? '&' : '?') ?>back=1');">儲存後返回</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/product" . $this->query) ?>';">返回</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/clockpicker/clockpicker.min.js") ?>"></script>
<script>
    var hash = window.location.hash;
    $('ul.nav-tabs li').eq(hash.substr(1)).addClass('active');
    $('.tab-pane').eq(hash.substr(1)).addClass('active');

    $(document).ready(function () {
        var $main = $('div.main-select').delegate('select', 'change', function () {
            get_category_option('minor', $(this).val()).done(function(){
                $minor.find('select').trigger('change');
            });
        });

        var $minor = $('div.minor-select').delegate('select', 'change', function () {
            get_product_order();
        });

        get_category_option('main', 0, '<?= $row->mainId ?>').done(function () {
            get_category_option('minor', $main.find('select').val(), '<?= $row->minorId ?>').done(function () {
                $minor.find('select').trigger('change');
            });
        });

        $('input#uploadImg').change(function () {
            var $this = $(this);
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                $this.siblings('p:last').children('img#preview').attr('src', e.target.result).show();
            };
        });

        $("div#preview").hover(
            function () {
                $(this).css("overflow", "visible").css("z-index", 99);
            },
            function () {
                $(this).css("overflow", "hidden").css("z-index", 1);
            }
        );

        $("#save, #back").click(function (e) {
        });
    });

    function get_category_option(type, prevId, selectId) {
        return $.ajax({
            url: '<?= site_url('backend/ajax/product/get_category_option') ?>' + (selectId ? '/' + selectId : ''),
            data: {type: type + 'Id', prevId: prevId},
            type: 'get',
            dataType: 'json',
            success: function (response) {
                $('div.' + type + '-select').html(response['select']);
            }
        });
    }

    function get_product_order() {
        var minorId = $("#minorId").val();
        if (minorId == <?= $row->minorId ?>) {
            $("#order").val(<?= $row->order ?>);
            return true;
        }

        return $.ajax({
            url: '<?= site_url('backend/ajax/product/get_product_order') ?>',
            data: {minorId: minorId},
            type: 'get',
            dataType: 'json',
            success: function (response) {
                $("#order").val(response['order']);
            }
        });
    }
</script>
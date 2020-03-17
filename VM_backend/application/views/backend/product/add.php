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

                    <h2>Add</h2>
                    <ul class="nav nav-tabs pull-right in"><?php $i = 1; ?>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Image List</a></li>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Size List</a></li>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Color List</a></li>
                        <?php if ($this->langList): ?>
                            <?php foreach ($this->langList as $lrow): ?>
                                <li><a data-toggle="tab" href="#hb<?= $i++ ?>"><?= $lrow->name ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                            <input type="hidden" name="productId" value="<?= $productId ?>">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Product</legend>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Visible</label>

                                            <div class="col-sm-9">
                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox" name="is_visible" value="1" checked>
                                                    <span>Yes</span>
                                                </label>

                                                <label class="radio radio-inline">
                                                    <input type="radio" class="radiobox" name="is_visible" value="0">
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="baseId">Base Category</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" id="baseId" name="baseId">
                                                    <option value="0" selected>None</option>
                                                    <?php if ($topList): ?>
                                                        <?php foreach ($topList as $crow): ?>
                                                            <option value="<?= $crow->categoryId ?>"><?= $crow->name ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="subId">Sub Category</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" id="subId" name="subId">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="category">Category</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" id="category" name="category">                                                    
                                                </select>
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
                                                    <img id="preview" src="" style="display:none;">
                                                </p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Image List</legend>
                                        
                                    </fieldset>
                                </div>

                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Size List</legend>
                                        
                                    </fieldset>
                                </div>

                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Color List</legend>
                                        
                                    </fieldset>
                                </div>

                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][pId]" value="<?= $productId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">
                                            <fieldset>
                                                <legend><?= $lrow->name ?></legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Name</label>

                                                    <div class="col-sm-9 col-lg-4">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][name]" required>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save">Save</button>
                                <button type="submit" class="btn btn-primary" id="back" onclick="$('#data-form').attr('action', '<?= $this->query . (!empty($this->query) ? '&' : '?') ?>back=1');">Return After Saving</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/product/category" . $this->query) ?>';">Return</button>
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
        $('input#uploadImg').change(function () {
            var $this = $(this);
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                $this.siblings('p:last').children('img#preview').attr('src', e.target.result).show();
            };
        });

        $("#save, #back").click(function (e) {
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

    $('#baseId').on('change',function(){
        var cId = $('#baseId').val();
        $.ajax({
            url:'<?= site_url('backend/ajax/product/category/get_category_option') ?>',
            data:{selected : '',cId : cId},
            type:'get',
            dataType:'json',
            success:function(response){
                $('#subId').html(response['option']);
            }
        })
    });

    $('#subId').on('change',function(){
        var subId = $('#subId').val();
        $.ajax({
            url:'<?= site_url('backend/ajax/product/category/get_category_option') ?>',
            data:{selected : '',cId : subId},
            type:'get',
            dataType:'json',
            success:function(response){
                $('#category').html(response['option']);
            }
        });
    });
</script>
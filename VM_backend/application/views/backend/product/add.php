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
                        <li class="active"><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Image List</a></li>
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
                                <div class="tab-pane active" id="hb<?= $i++ ?>">
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
                                                <select class="form-control" id="baseId" name="baseId" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    <option value="" selected>None</option>
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
                                                <select class="form-control" id="subId" name="subId" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="category">Category</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" id="category" name="cId" data-bv-notempty="true" data-bv-notempty-message=" ">                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="category">Brand</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <select class="form-control" name="brandId" data-bv-notempty="true" data-bv-notempty-message=" ">                                                    
                                                    <?php foreach ($brandList as $brandKey => $brandValue){ ?>
                                                        <option value="<?= $brandValue->brandId ?>"><?= $brandValue->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="price">Price</label>

                                            <div class="col-sm-9 col-lg-4">
                                                <input type="integer" class="form-control" name="price" data-bv-notempty="true" data-bv-notempty-message=" ">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="size">Size</label>

                                            <div class="col-sm-9">
                                                <?php foreach($size_chart as $sizeKey => $sizeValue){ ?>
                                                    <input type="checkbox" value="<?= $sizeValue->size ?>" name='size[]'> <?= $sizeValue->size ?>&nbsp;&nbsp;&nbsp;
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="productImg"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="圖示格式不符">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture size is <strong>300 x 400</strong>.type is<strong>JPG、PNG</strong>。
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
                                        <fieldset>
                                            <input type="hidden" id="aId" value="<?= @$postId ?>">
                                            <table id="image_list" class="table table-bordered table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th width="60%" class="text-center">Image</th>
                                                        <th width="20%" class="text-center">Youtube</th>
                                                        <th width="20%" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </fieldset>
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

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][name]" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Introduction</label>

                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" id="name-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][introduction]" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Description</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][description]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "></textarea>                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Return</label>

                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="langList[<?= $lrow->langId ?>][return]" rows="10" data-bv-notempty="true" data-bv-notempty-message=" "></textarea>                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="name-<?= $lrow->langId ?>">Detail</label>

                                                    <div class="col-sm-9">
                                                        <div id="content-edit"></div>
                                                        <input type="hidden" id="content" name="langList[<?= $lrow->langId ?>][detail]">
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
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/product/product" . $this->query) ?>';">Return</button>
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
<link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/summernote.css") ?>">
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote-zh-TW.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/clockpicker/clockpicker.min.js") ?>"></script>
<script>
    var hash = window.location.hash;

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
            $('div#content-edit').each(function () {
                var content = $(this).summernote('code').replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
                    return '&#' + i.charCodeAt(0) + ';';
                });

                $(this).siblings('input#content').val(content);
            });
        });

        $('div#content-edit').each(function () {
            $(this).summernote({
                height: 500,
                lang: 'zh-TW',
                toolbar: [
                    ['font', ['clear']],
                    ['insert', ['picture', 'link', 'video']],
                    ['misc', ['codeview']]
                    //['font', ['fontname', 'fontsize', 'color', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subsript', 'clear']],
                    //['para', ['style', 'ol', 'ul', 'paragraph', 'height']],
                    //['insert', ['picture', 'link', 'video', 'table', 'hr']],
                    //['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
                ],
                callbacks: {
                    onImageUpload: function (files) {
                        for (var i = 0; i < files.length; i++) {
                            sendFile(files[i], $(this));
                        }
                    }
                }
            });
        });

        var responsiveHelper_dt_basic = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        //image
        $image_table = $('#image_list').DataTable({
            "displayStart": <?= $start = check_input_value($this->input->get('start', true), true, 0) ?>,   //總共幾筆
            "pageLength": <?= $length = check_input_value($this->input->get('length', true), true, 25) ?>,  //每頁幾筆
            "oSearch": {"sSearch": "<?= $this->input->get('search', true) ?>"},  //文字查詢
            "autoWidth": false,
            "ordering": false,
            "serverSide": true,
            "sDom": "<'dt-toolbar'<'col-sm-8 hidden-xs'><'col-xs-12 col-sm-4'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",  //功能表
            "oTableTools": {
                "aButtons": [{
                    "sExtends": "text",
                    "sButtonText": '<i class="fa fa-plus" style="color:white"></i> <span class="hidden-mobile" style="color:white">Add Image</span>',
                    "sButtonClass": "btn-lg btn-primary",
                    "fnInit": function (nButton, oConfig) {
                        $(nButton).css('margin-left', 5).css('text-shadow','0 -1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.3)').attr('onclick', 'imgUpload("new")');
                    }
                }]
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/product/product/get_product_img") ?>",  //傳到homepage slider
                "data": function (data) {
                    data.productId = '<?= $productId ?>'
                }
            },
            "columns": [
                {class: "", data: "preview"},
                {class: "", data: "youtube"},
                {class: "", data: "action"}
            ],
            "preDrawCallback": function () {   //一載入的動作
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#image_list'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {  //每筆資料的動作
                responsiveHelper_dt_basic.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {  //每更新存檔的動作
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
            }
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
                $('#category').html('');
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

    /***** 圖片列表 ****/
    function imgUpload(Id)
    {        
        swal({
            title: 'Upload image',
            html:'<input type="file" id="transactionImg" onchange="change_img()" class="swal2-file transactionImg" placeholder="" style="display: block;width:92%"><br><strong>Note:</strong> Picture size is <strong>300 x 400</strong>.type is<strong>JPG、PNG</strong><br><input type="file" id="transactionImg" onchange="change_img()" class="swal2-file transactionImg" placeholder="" style="display: block;width:92%"><br><strong>Note:</strong> Picture size is <strong>470 x 627</strong>.type is<strong>JPG、PNG</strong><br><input type="file" id="transactionImg" multiple="multiple" onchange="change_img()" class="swal2-file transactionImg" placeholder="" style="display: block;width:92%"><br><strong>Note:</strong> Picture size is <strong>600 x 800</strong>.type is<strong>JPG、PNG</strong><br><span stle="float:left">Youtube</span><input type="text" id="youtube" name="youtube" style="width:80%"></p>'        
        }).then(function (e) {
            var data = new FormData();
            if(file != undefined && file != ''){
                $.each(file,function(key,value){
                    data.append(key,value);
                });
            }        
            data.append('youtube',$('#youtube').val());
            data.append('productId','<?= $productId ?>');
            data.append('Id',Id);
            $.ajax({
                url:'<?= site_url("backend/ajax/product/product/upload_img") ?>',
                type:'post',
                data:data,
                cache:false,
                dataType:'json',
                processData:false,
                contentType:false,
                success:function(response){
                    if(response['status']){
                        $image_table.draw();
                        file = '';
                    }
                }
            });                
        })
    }

    function delete_imgList(Id){
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true
        }).then(function(result){
            $.ajax({
                url:'<?= site_url("backend/ajax/product/product/delete_img") ?>',
                type:'post',
                data:{Id : Id},
                dataType:'json',
                success:function(response){
                    if(response['status']){
                        $image_table.draw();
                        file = '';
                    }
                }
            });
        });
    }

    function change_img(){
        file = event.target.files;
    };
    $('form').bootstrapValidator({
        excluded: ""
    });    

    function sendFile(file, editor) {
        var data = new FormData();
        data.append('productId', '<?= $productId ?>');
        data.append("file", file);

        return $.ajax({
            data: data,
            type: "POST",
            url: "<?= site_url("backend/ajax/product/product/upload") ?>",
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                editor.summernote('editor.insertImage', url);
            }
        });
    }
</script>
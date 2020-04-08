<style type="text/css">
    .help-block #preview {
        width: auto;
        max-width: 90%;
        max-height: 300px;
        margin-bottom: 6px;
        padding: 3px;
    }
    .dataTables_filter {
        float: none;
    }

    .main-select, .minor-select, .category-select{
        padding-left: 5px;
        padding-bottom: 5px;
    }
    .modal-dialog{
        width:80%;
    }
    .modal-header{
        background-color:#ffff;
    }
    #preview img {
        width: 100px;
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
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>
                        <?php if ($this->langList): ?>
                            <?php foreach ($this->langList as $lrow): ?>
                                <li><a data-toggle="tab" href="#hb<?= $i++ ?>"><?= $lrow->name ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Related Products</a></li>
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
                            <input type="hidden" name="inspirationId" value="<?= $inspirationId ?>">
                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Inspiration</legend>
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
                                            <label class="col-sm-2 control-label">Image</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="btn btn-default" id="uploadImg" name="inspirationImg"
                                                    data-bv-notempty="true" data-bv-notempty-message=" "
                                                    data-bv-file="true"
                                                    data-bv-file-extension="jpeg,jpg,png,gif"
                                                    data-bv-file-type="image/jpeg,image/png,image/gif"
                                                    data-bv-file-message="Type error">

                                                <p class="help-block">
                                                    <strong>Note:</strong>Picture width is <strong>240</strong>. Format is JPG and PNG</strong>。
                                                </p>

                                                <p class="help-block">
                                                    <img id="preview" src="">
                                                </p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">  
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][iId]" value="<?= $inspirationId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">

                                            <fieldset data-id="<?= $lrow->langId ?>">
                                                <legend>Inspiration Content</legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Title</label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="langList[<?= $lrow->langId ?>][title]" data-bv-notempty="true" data-bv-notempty-message=" ">                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Content</label>

                                                    <div class="col-sm-9">
                                                        <div id="content-edit"><?= @$langData->content ?></div>
                                                        <input type="hidden" id="content" name="langList[<?= $lrow->langId ?>][content]"  data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>                                                
                                            </fieldset>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Related Products
                                        <a class="btn btn-default btn-primary" style="margin-left: 5px; text-shadow: rgba(0, 0, 0, 0.5) 0px -1px 0px, rgba(255, 255, 255, 0.3) 0px 1px 0px;float:right;" data-toggle="modal" data-target="#myModal"><span><i class="fa fa-plus" style="color:white"></i> <span class="hidden-mobile" style="color:white">Add Product</span></span></a>

                                        </legend>
                                        <table class="table table-bordered table-striped text-center" id="table_related_product">
                                            <thead>
                                            <tr>
                                                <th width="12%" class="text-center hidden-tablet hidden-md">Image</th>
                                                <th width="12%" class="text-center">Name</th>
                                                <th width="15%" class="text-center">Base Category</th>
                                                <th width="15%" class="text-center">Sub Category</th>
                                                <th width="15%" class="text-center">Category</th>
                                                <th width="10%" class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>                                               
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>                            
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save" form="data-form">Save</button>
                                <button type="submit" class="btn btn-primary" id="back" form="data-form" onclick="$('#data-form').attr('action', '<?= $this->query . (!empty($this->query) ? '&' : '?') ?>back=1');">Return After Saving</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/homepage/inspiration" . $this->query) ?>';">Return</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

<!-- dialog -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" style="margin-top: -15px;font-size:25px">&times;</button>
          <h4 class="modal-title"></h4>
        </div>    
        <div class="modal-content">    
            <div class="jarviswidget jarviswidget-color-darken" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false"
                data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false" style="width: 95%;margin-left: 2.5%;margin-top: 10px;">

                <header>
                    <span class="widget-icon"><i class="fa fa-table"></i></span>

                    <h2>Product List</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table id="dt_basic" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th width="30" class="text-center hidden-xs">Visible</th>
                                            <th width="12%" class="text-center hidden-tablet hidden-md">Image</th>
                                            <th width="12%" class="text-center">Name</th>
                                            <th width="15%" class="text-center">Base Category</th>
                                            <th width="15%" class="text-center">Sub Category</th>
                                            <th width="15%" class="text-center">Category</th>
                                            <th width="160" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url("assets/backend/js/plugin/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/datatables/dataTables.tableTools.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/datatables/dataTables.bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/backend/js/plugin/datatable-responsive/datatables.responsive.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/clockpicker/clockpicker.min.js") ?>"></script>
<link media="all" type="text/css" rel="stylesheet" href="<?= base_url("assets/backend/css/summernote.css") ?>">
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/backend/js/plugin/summernote/summernote-zh-TW.js") ?>"></script>
<script>
    var hash = window.location.hash;
    var responsiveHelper_dt_basic = undefined;
    var breakpointDefinition = {
        tablet: 1024,
        phone: 480
    };
    var count = 0;
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

        var $model_Table = $('#dt_basic').DataTable({
            "displayStart": <?= $start = check_input_value($this->input->get('start', true), true, 0) ?>,
            "pageLength": <?= $length = check_input_value($this->input->get('length', true), true, 25) ?>,
            "oSearch": {"sSearch": "<?= $this->input->get('search', true) ?>"},
            "autoWidth": false,
            "ordering": false,
            "serverSide": true,
            "deferRender":true,
            "sDom": "<'dt-toolbar'<'col-sm-11 hidden-xs' f<'main-select input-group'><'minor-select input-group'><'category-select input-group'>><'col-xs-12 col-sm-1'Tl>>" + "t" + "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oTableTools": {
                "aButtons": []
            },
            "ajax": {
                "url": "<?= site_url("backend/ajax/homepage/inspiration/get_product_data") ?>",
                "data": function (data) {
                    data.inspirationId = '<?= $inspirationId ?>';
                    data.baseId = $('#myModal').find('div.main-select select').val();
                    data.subId = $('#myModal').find('div.minor-select select').val();
                    data.categoryId = $('#myModal').find('div.category-select select').val();
                },
                "type":'post'
            },
            "columns": [
                {class: "hidden-xs", data: "visible"},
                {class: "hidden-tablet hidden-md", data: "preview"},
                {class: "", data: "name"},
                {class: "", data: "base_category"},
                {class: "", data: "sub_category"},
                {class: "", data: "category"},
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
                $categorySelect = $('div.main-select').html('<span class="input-group-addon">Base Category</span><select class="form-control"></select>')
                .find('select').html("<option value=''>All</option>").change(function(){
                    var category = $(this).val();                    
                    get_area_option(category).done(function(response){                                                
                        $areaList.html(response['option']);
                        $('div.minor-select select').val('0');
                        $('div.category-select select').val('0');
                    });
                    $model_Table.draw();
                });

                get_category_option('<?= $this->input->get('cId', true) ?>').done(function (respone) {
                    $categorySelect.append(respone['option']);
                });

                $areaList = $('div.minor-select').html('<span class="input-group-addon">Sub Category</span><select class="form-control"></select>')
                    .find('select').html('<option value="">All</option>').change(function(){
                        var category2 = $(this).val();                    
                        get_area_option(category2).done(function(response){
                            $category3.html(response['option']);
                            $('div.category-select select').val('0');
                        });
                        $model_Table.draw();

                    });

                get_area_option('<?= $this->input->get('cId', true) ?>').done(function(response){                       
                    $areaList.html(response['option']);
                });

                $category3 = $('div.category-select').html('<span class="input-group-addon">Category</span><select class="form-control"></select>')
                    .find('select').html('').change(function(){                   
                        $model_Table.draw();
                    });
            }
        });

        $('form').bootstrapValidator({
            excluded: ""
        });

        $('body').on('click','button.add_product', function (){
            var error = 0;
            var id = $(this).data('id');
            $.each($('#table_related_product').find('input'),function(key,index){
                if($(index).val() == id){
                    error = 1;
                }
            });
            if(error == 0){
                $('#table_related_product tbody').append('<tr id="new'+count+'">'+
                '<td>'+'<img src="<?= base_url() ?>'+$(this).data('img')+'" style="height:200px">'+'</td>'+
                '<td>'+$(this).data('name')+'</td>'+
                '<td>'+$(this).data('base_category')+'</td>'+
                '<td>'+$(this).data('sub_category')+'</td>'+
                '<td>'+$(this).data('category')+'</td>'+
                '<td><button type="button" class="btn btn-danger" onclick="delete_product(\'new'+count+'\')"><i class="glyphicon glyphicon-trash"></i><span class="hidden-mobile"> Delete</span></button></td>'+
                '<input type="hidden" name="related[new'+count+'][Id]" value="new">'+
                '<input type="hidden" name="related[new'+count+'][pid]" value="'+$(this).data('id')+'">'+
                '<input type="hidden" name="related[new'+count+'][iId]" value="<?= $inspirationId ?>">'+
                '</tr>'
                );
            }
            count++;
            $('#myModal').find('.close').click();
        });     
    });

    function get_category_option(selectId) {
        return $.ajax({
            url: '<?= site_url('backend/ajax/product/category/get_first_option') ?>',
            data: {selectId: selectId},
            type: 'get',
            dataType: 'json'
        });
    }

    function get_area_option(category){
        return $.ajax({
            url:'<?= site_url('backend/ajax/product/category/get_category_option') ?>',
            type:'get',
            data:{selected : '',cId : category},
            dataType:'json',
        });
    }

    function sendFile(file, editor) {
        var data = new FormData();
        data.append('inspirationId', '<?= $inspirationId ?>');
        data.append("file", file);

        return $.ajax({
            data: data,
            type: "POST",
            url: "<?= site_url("backend/ajax/homepage/inspiration/upload") ?>",
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                editor.summernote('editor.insertImage', url);
            }
        });
    }
</script>
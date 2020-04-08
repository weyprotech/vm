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
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Content</a></li>
                        <li><a data-toggle="tab" href="#hb<?= $i++ ?>">Image</a></li>
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
                            <input type="hidden" id="postId" name="postId" value="<?= $postId ?>">
                            <input type="hidden" name="is_enable" value="1">

                            <div id="content" class="tab-content"><?php $i = 1; ?>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <legend>Post</legend>

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
                                    </fieldset>
                                </div>
                                <div class="tab-pane" id="hb<?= $i++ ?>">
                                    <fieldset>
                                        <input type="hidden" id="aId" value="<?= @$postId ?>">
                                        <table id="dt_basic" class="table table-bordered table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th width="60%" class="text-center hidden-tablet hidden-md">Image</th>
                                                    <th width="20%" class="text-center hidden-tablet hidden-md">Youtube</th>
                                                    <th width="20%" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </fieldset>
                                </div>
                                <?php if ($this->langList): ?>
                                    <?php foreach ($this->langList as $lrow): ?>
                                        <div class="tab-pane" id="hb<?= $i++ ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][postId]" value="<?= $postId ?>">
                                            <input type="hidden" name="langList[<?= $lrow->langId ?>][langId]" value="<?= $lrow->langId ?>">
                                            <fieldset>
                                                <legend><?= $lrow->name ?></legend>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="title-<?= $lrow->langId ?>">Title</label>

                                                    <div class="col-sm-6">
                                                        <input class="form-control" type="text" id="title-<?= $lrow->langId ?>" name="langList[<?= $lrow->langId ?>][title]" data-bv-notempty="true" data-bv-notempty-message=" ">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Content</label>

                                                    <div class="col-sm-9">
                                                        <div id="content-edit"></div>
                                                        <input type="hidden" id="content" name="langList[<?= $lrow->langId ?>][content]" data-bv-notempty="true" data-bv-notempty-message=" ">
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
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/designer/post/index/".$designerId . $this->query) ?>';">Return</button>
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
    $('ul.nav-tabs li').eq(hash.substr(1)).addClass('active');
    $('.tab-pane').eq(hash.substr(1)).addClass('active');
    var file;

    $(document).ready(function () {
        $('input#uploadImg').change(function () {
            var $this = $(this);
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                $this.siblings('p:last').children('img#preview').attr('src', e.target.result).show();
            };
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

        $("#save, #back").click(function (e) {
            $('div#content-edit').each(function () {
                var content = $(this).summernote('code').replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
                    return '&#' + i.charCodeAt(0) + ';';
                });

                $(this).siblings('input#content').val(content);
            });
        });

        var responsiveHelper_dt_basic = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };
        $Table = $('#dt_basic').DataTable({
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
                "url": "<?= site_url("backend/ajax/designer/post/get_post_img") ?>",  //傳到homepage slider
                'type':'get',
                "data": function (data) {
                    data.postid = '<?= $postId ?>';
                }
            },
            "columns": [
                {class: "hidden-xs", data: "preview"},
                {class: "", data: "youtube"},
                {class: "", data: "action"}
            ],
            "preDrawCallback": function () {   //一載入的動作
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
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

    function sendFile(file, editor) {
        var data = new FormData();
        data.append('postId', '<?= $postId ?>');
        data.append("file", file);

        return $.ajax({
            data: data,
            type: "POST",
            url: "<?= site_url("backend/ajax/designer/post/upload") ?>",
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                editor.summernote('editor.insertImage', url);
            }
        });
    }

    function imgUpload(Id)
    {
        var postId = $('#postId').val();
        swal({
            title: 'Upload image or video',
            html:'<input type="file" id="transactionImg" multiple="multiple" onchange="change_img()" class="swal2-file transactionImg" placeholder="" style="display: block;width:92%"><br><strong>Note:</strong> Picture size is <strong>510 x 288</strong>.type is<strong>JPG、PNG</strong><br><span stle="float:left">Youtube</span><input type="text" id="youtube" name="youtube" style="width:80%"></p>'
        }).then(function (e) {
            var data = new FormData();
            if(file != undefined && file != ''){
                $.each(file,function(key,value){
                    data.append(key,value);
                });
            }        
            data.append('youtube',$('#youtube').val());
            data.append('postId',postId);
            data.append('Id',Id);
            $.ajax({
                url:'<?= site_url("backend/ajax/designer/post/upload_img") ?>',
                type:'post',
                data:data,
                cache:false,
                dataType:'json',
                processData:false,
                contentType:false,
                success:function(response){
                    if(response['status']){
                        $Table.draw();
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
                url:'<?= site_url("backend/ajax/designer/post/delete_img") ?>',
                type:'post',
                data:{Id : Id},
                dataType:'json',
                success:function(response){
                    if(response['status']){
                        $Table.draw();
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
</script>
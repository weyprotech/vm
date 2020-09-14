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
                    <h2>Add Member</h2>
                </header>

                <div>
                    <div class="widget-body no-padding">
                        <form id="data-form" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="is_enable" value="1">
                            <input type="hidden" name="uuid" value="<?= $row->uuid ?>">

                            <div id="content" class="tab-content">
                                <fieldset>
                                    <legend>Member</legend>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="email">Email</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="text" id="email" name="email" value="<?= $row->email ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="password">Password</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="password" id="password" name="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="re_password">Confirm Password</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input type="password" class="form-control" id="re_password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="point">point</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input type="text" class="form-control" id="point" name="point" value="<?= $row->point ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="dividend">Dividend</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input type="text" class="form-control" id="dividend" value="<?= $row->dividend ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="first_name">First Name</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="text" id="first_name" name="first_name" value="<?= $row->first_name ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="last_name">Last Name</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="text" id="last_name" name="last_name" value="<?= $row->last_name ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="gender">Gender</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <label class="radio radio-inline">
                                                <input type="radio" class="radiobox" name="gender" value="0" <?= $row->gender == 0 ? 'checked' : '' ?>>
                                                <span>Men</span>
                                            </label>

                                            <label class="radio radio-inline">
                                                <input type="radio" class="radiobox" name="gender" value="1" <?= $row->gender == 1 ? 'checked' : ''?>>
                                                <span>Women</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="age">Age</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="number" id="age" name="age" value="<?= $row->age ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Image</label>

                                        <div class="col-sm-9">
                                            <input type="file" class="btn btn-default" id="uploadImg" name="memberImg"
                                                
                                                data-bv-file="true"
                                                data-bv-file-extension="jpeg,jpg,png,gif"
                                                data-bv-file-type="image/jpeg,image/png,image/gif"
                                                data-bv-file-message="圖示格式不符">

                                            <p class="help-block">
                                                <strong>Note:</strong> Resolution is <strong>100 x 100</strong>.type is <strong>JPG、PNG</strong>。
                                            </p>

                                            <p class="help-block">
                                                <?php $memberImg = check_file_path($row->memberImg); ?>
                                                <img id="preview" src="<?= $memberImg ?>"<?= !$memberImg ? "display:none;" : "" ?>>
                                            </p>
                                        </div>
                                    </div>
<!-- 
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="phone_area_code">Phone Area Code</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="text" id="phone_area_code" name="phone_area_code" value="<?= $row->phone_area_code ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="phone">Phone</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="text" id="phone" name="phone" value="<?= $row->phone ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="country">Country</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <select class="form-control" name="country">
                                                <?php foreach ($countryList as $countryKey => $countryValue){ ?>
                                                    <option value="<?= $countryKey ?>" <?= $countryKey == $row->country ? 'selected' : '' ?>><?= $countryValue ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>                            

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="state">State/Region</label>

                                        <div class="col-sm-9 col-lg-6">
                                            <input class="form-control" type="text" id="state" name="state" value="<?= $row->state ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="address">Address</label>
                                        <div class="col-sm-9 col-lg-6">
                                            <input type="text" class="form-control" id="address" name="address" value="<?= $row->address ?>" data-bv-notempty="true" data-bv-notempty-message=" ">
                                        </div>
                                    </div> -->
                                </fieldset>
                            </div>

                            <div class="widget-footer">
                                <button type="submit" class="btn btn-primary" id="save">Save</button>
                                <button type="submit" class="btn btn-primary" id="back" onclick="$('#data-form').attr('action', '<?= @$this->query . (!empty($this->query) ? '&' : '?') ?>back=1');">Return After Saving</button>
                                <button type="button" class="btn btn-default" onclick="location.href='<?= site_url("backend/member/member" . @$this->query) ?>';">Return</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script>
    $("button#save, button#back").click(function () {
        var pwd = $("input#password").val();
        var re_pwd = $("input#re_password").val();

        if (pwd != '' || re_pwd != '') {
            if (pwd != re_pwd) {
                alert('新密碼不相符，請重新確認!');
                return false;
            }
        }
    });

    $(document).ready(function () {
        $('input#uploadImg').change(function () {
            var $this = $(this);
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                $this.siblings('p:last').children('img#preview').attr('src', e.target.result).show();
            };
        });

        $('form').bootstrapValidator({
            excluded: ""
        });
    });

    $("#save, #back").click(function (e) {
    });

</script>
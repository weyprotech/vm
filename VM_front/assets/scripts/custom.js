var website = function () {
    var siteUrl = '', baseUrl = '';
    var backendUrl = "http://vm-backend.4webdemo.com/";

    var init = function (site, base) {
        siteUrl = site;
        baseUrl = base;

        var $langSelect = $('#select-lang'), $searchText = $('#text-search'), $searchBtn = $('#btn-search');
        var $brand_more = $('#brand_more'),$website_set = $('#website_set'),$event_more = $('#event_more');
        var $login = $('#login'),$edit_account_save = $('#edit_account_save'),$more_popular_designers = $('#more_popular_designers');

        var error = 0;

        $langSelect.change(function () {
            change_lang($(this).val()).done(function (response) {
                if (response['status']) location.href = response['url'];
            });
        });

        $searchText.keypress(function (event) {
            if (event.keyCode == 13 && !isEmpty($searchText.val())) {
                location.href = site_url('search?s=' + $searchText.val());
            }
        });

        $searchBtn.click(function(){
            if(!isEmpty($searchText.val())) {
                location.href = site_url('search?s=' + $searchText.val());
            }
        });

        $brand_more.on('click', function(){
            var start = $brand_more.data('start');
            var result = '';
            $.ajax({
                url:site_url('ajax/brand/get_brand_data'),
                data:{start : start},
                type:'get',
                dataType:'json',
                success:function(response){
                    if(response['brandList']){
                        $.each(response['brandList'],function(key,value){
                            result += '<div class="item">'+
                            '<a href="brand_story.html">'+
                                '<div class="thumb">'+
                                    '<div class="pic" style="background-image: url('+backend_url(value.brandindexImg)+');"><img class="size" src="'+base_url('assets/images/size_1x1.png')+'"></div>'+
                                '</div>'+
                                '<p>'+value.name+'</p>'+
                                '<div class="designer_name">'+
                                    (value.grade == 1 ? '<i class="icon_diamond_s"></i>' : '')+                                
                                    '<img class="flag" src="'+base_url('assets/images/flag/'+value.country+'.png')+'"><span>'+value.designer_name+'</span>'+
                                '</div>'+
                            '</a>'+
                        '</div>'
                        });
                        $('#brand_explore').append(result);
                        $brand_more.data('start',start+10);
                    }                   
                }
            });
        });

        //更多有名的設計師
        $more_popular_designers.on('click',function(){
            var start = $more_popular_designers.data('start');
            var result = '';
            $.ajax({
                url:site_url('ajax/popular_designers/get_popular_data'),
                data:{start : start},
                type:'get',
                dataType:'json',
                success:function(response){
                    if(response['designerList']){
                        $.each(response['designerList'], function(key,value){
                            result += '<div class="popular_block">'+
                            '<div class="popular_block_inner">'+
                                '<div class="popular_picture">'+
                                    '<a class="thumb" href="'+site_url('designers/home')+'?designerId='+value.designerId+'">'+
                                        '<div class="pic" style="background-image: url('+backend_url(value.designImg)+');">'+
                                            '<img class="size" src="'+base_url('assets/images/size_3x4.png')+'">'+
                                        '</div>'+
                                    '</a>'+
                                    '<a class="btn common" href="'+site_url('designers/home')+'?designerId='+value.designerId+'">Read more</a>'+
                                '</div>'+
                                '<div class="popular_content">'+
                                    '<a class="designer_info" href="'+site_url('designers/home')+'?designerId='+value.designerId+'">'+
                                        '<div class="profile_picture">'+
                                            '<div class="pic" style="background-image: url('+backend_url(value.designiconImg)+')">'+
                                                '<img class="size" src="'+base_url('assets/images/size_1x1.png')+'">'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="designer_name">'+
                                            (value.grade == 1 ? '<i class="icon_diamond_b"></i>' : '')+
                                            '<span>'+value.name+'</span>'+
                                        '</div>'+
                                    '</a>'+
                                    '<div class="text">'+value.description+'</div>'+
                                    value.first_img+                                
                                '</div>'+
                            '</div>'+
                        '</div>'
                        });
                        $.getScript(base_url('assets/scripts/main.js')); //重讀js
                        
                        $('.popular_block_wrapper').append(result);
                        $more_popular_designers.data('start',start+10);                    
                    };
                }
            })
        });

        //語言
        $website_set.on('click',function(){
            doCookieSetup('language',$('#languange_select').val());
            doCookieSetup('money_type',$('#languange_select').val());        
        });

        //消息更多
        $event_more.on('click',function(){
            var count = $(this).data('count');
            var notin = $(this).data('notin');
            $.ajax({ 
                url:site_url('ajax/events/get_more'),
                type:'get',
                dataType:'json',
                data:{count : count,notin : notin},
                success:function(response){
                    $.each(response['events'], function(key,value){
                        $('#explore_list').append('<div class="item">'+
                        '<a href="event_detail.html">'+
                            '<div class="date">'+value.date+'</div>'+
                            '<div class="thumb">'+
                                '<div class="pic" style="background-image: url('+value.exploreImg+');">'+
                                    '<img class="size" src="'+base_url('assets/images/size_1x1.png')+'">'+
                                '</div>'+
                            '</div>'+
                            '<h3 class="event_title">'+value.title+'</h3>'+
                        '</a>'+
                    '</div>');
                    });
                    $event_more.data('count',count+10);
                    console.log($event_more.data('count'));
                }
            });
        });

        //登入
        $login.on('click',function(){
            error = 0;
            $('#email').css('border-color','#b4a189');
            $('#password').css('border-color','#b4a189');

            if($('#email').val() == ''){
                $('#email').css('border-color','red');
                error = 1;
            }
            if($('#password').val() == ''){
                $('#password').css('border-color','red');
                error = 1;
            }
            var email = $('#email').val();
            var password = $('#password').val();
            var remember = '';
            if ($("#remember").is(":checked")) {  
                remember = 1;
            } else {
                remember = '';            
            }
            if(error == 0){
                $.ajax({
                    url:site_url('ajax/member/check_member'),
                    data:{email : email,password : password,remember : remember},
                    type:'post',
                    dataType:'json',
                    success:function(response){
                        if(response.status == 'error'){
                           swal({
                                html:'Incorrect account password',
                                type:'error',                                
                           });
                           $('.swal2-container').css('z-index','100000');
                           $('#password').val('');                                              
                        }else{
                            location.href= site_url('member');
                        }
                    }
                });
            }
        });

        //編輯帳號儲存
        $edit_account_save.on('click',function(){
            var password = $('#password').val();
            var password_confirm = $('#confirm_password').val();
            var error = 0;
            if(password == ''){
                $('#password').css('border-color','red');
                error = 1;
            }
            if(password_confirm == ''){
                $('#password_confirm').css('border-color','red');
                error = 1;
            }
            if(error == 0){
                if(password == password_confirm){
                    $('#edit_account_form').submit();
                }else{
                    swal({
                        html:'password and password confirmation is not match',
                        type:'error'
                    });
                    // $('#password').val('');
                    // $('#password_confirm').val('');
                    $('.swal2-container').css('z-index','100000');
                }
            }
        });

        //just for you寄出
        $('body').on('click','#just_send',function(){
            var data = $('#just_form').serializeArray();
            var error = 0;
            emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
            $.each(data,function(key,value){
                if(value.value == ''){
                    console.log(value);
                    error = 1;
                    swal({
                        title:"cann't empty",
                        type:'error'
                    });
                    $('.swal2-container').css('z-index','100000');

                }else if(value.name == 'email'){
                    if(value.value.search(emailRule)== -1){
                        error = 1;
                        swal({
                            title:"Email is illegal",
                            type:'error'
                        });
                        $('.swal2-container').css('z-index','100000');

                    }
                }
            });
            if(error == 0){
                $('.mfp-close').click();
                $.ajax({
                    url:site_url('ajax/designers/set_just'),          
                    data:data,
                    type:'post',
                    dataType:'json',
                    success:function(response){
                        swal({
                            title:response['response'],
                            type:'success'
                        });
                    }
                });
            }
        });

        //message寄出
        $('body').on('click','#message_send',function(){
            var data = $('#message_form').serializeArray();
            var error = 0;
            emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
            $.each(data,function(key,value){
                if(value.value == ''){
                    console.log(value);
                    error = 1;
                    swal({
                        title:"cann't empty",
                        type:'error'
                    });
                    $('.swal2-container').css('z-index','100000');

                }else if(value.name == 'email'){
                    if(value.value.search(emailRule)== -1){
                        error = 1;
                        swal({
                            title:"Email is illegal",
                            type:'error'
                        });
                        $('.swal2-container').css('z-index','100000');

                    }
                }
            });
            if(error == 0){
                $('.mfp-close').click();
                $.ajax({
                    url:site_url('ajax/designers/set_message'),          
                    data:data,
                    type:'post',
                    dataType:'json',
                    success:function(response){
                        swal({
                            title:response['response'],
                            type:'success'
                        });
                    }
                });
            }
        });

        //辦帳號
        $('body').on('click','#create_account',function(){
            var email = $('#create_email').val();
            var password = $('#create_password').val();
            var password_confirm = $('#create_password_confirm').val();
            var error = 0;
            emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
            if(email == ''){
                $('#create_email').css('border-color','red');
                error = 1;
            }
            if(password == ''){
                $('#create_password').css('border-color','red');
                error = 1;
            }
            if(password_confirm == ''){
                $('#create_password_confirm').css('border-color','red');
                error = 1;
            }
            if(error == 0){
                if(email.search(emailRule)!= -1){
                    if(password != password_confirm){
                        swal({
                            html:'password and password confirmation is not match',
                            type:'error'
                        });
                    }else{
                        $.ajax({
                            url:website.Site_url('ajax/create_account/index'),
                            data:{email : email,password : password},
                            type: 'post',
                            dataType: 'json',
                            success:function(response){
                                if(response['status'] == 'success'){
                                    swal({                    
                                        html:'Send validate email to your email',
                                        type:'success'
                                    });
                                }else{
                                    swal({                    
                                        html:response['message'],
                                        type:'error'
                                    });
                                }
                                $('.mfp-close').click();
                                $('.swal2-container').css('z-index','100000');
                            }
                        })
                    }
                }else{
                    swal({
                        html:'Email is illegal',
                        type:'error'
                    });
                    $('.swal2-container').css('z-index','100000');
                }
            }
        });
    };
    
    //cookie保存
    function doCookieSetup(name, value) {
        var expires = new Date();
        //有效時間保存 2 天 2*24*60*60*1000
        expires.setTime(expires.getTime() + 172800000);
        document.cookie = name + "=" + escape(value) + ";expires=" + expires.toGMTString()
    }

    function change_lang(lang) {
        return $.get(site_url("ajax/switchLang"), {lang: lang, url: location.href}, 'json');
    }

    function isEmpty(value) {
        return (value == undefined) || (value == null) || (value == "");
    }

    var site_url = function (url) {
        if (url == undefined) return siteUrl;
        return siteUrl + "/" + url;
    };

    var base_url = function (url) {
        if (url == undefined) return baseUrl;
        return baseUrl + "/" + url;
    };


    var backend_url = function (url) {
        if(url == undefined) return backendUrl;
        return backendUrl + "/" + url;
    }

    return {
        Init: init,
        Site_url: site_url,
        Base_url: base_url,
        IsEmpty: isEmpty,
        Ajax: function (url, data, type) {
            return $.ajax({ url: site_url(url), data: data || {}, type: type || 'get', dataType: 'json' });
        }
    };
}();
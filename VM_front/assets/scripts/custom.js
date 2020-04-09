var website = function () {
    var siteUrl = '', baseUrl = '';
    var backendUrl = "http://localhost/vm/vm_backend/";

    var init = function (site, base) {
        siteUrl = site;
        baseUrl = base;

        var $langSelect = $('#select-lang'), $searchText = $('#text-search'), $searchBtn = $('#btn-search');
        var $brand_more = $('#brand_more'),$website_set = $('#website_set'),$event_more = $('#event_more');

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

        $website_set.on('click',function(){
            doCookieSetup('language',$('#languange_select').val());
            doCookieSetup('money_type',$('#languange_select').val());        
        });

        $event_more.on('click',function(){
            var page = $(this).data('page');
            var notin = $(this).data('notin');
            $.ajax({ 
                url:site_url('ajax/events/get_more'),
                type:'get',
                dataType:'json',
                data:{page : page,notin : notin},
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
                }
            });
        });
    };
    
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
var website = function () {
    var siteUrl = '', baseUrl = '';

    var init = function (site, base) {
        siteUrl = site;
        baseUrl = base;

        var $langSelect = $('#select-lang'), $searchText = $('#text-search'), $searchBtn = $('#btn-search');

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
    };

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
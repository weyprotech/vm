<script>

$(function() {
    <?php 
    if(empty($this->langFile)) {
    ?>
        // 開啟選擇語言和幣別的跳窗
        popupEntrance();
    <?php 
    } 
    ?>
    
    // Map
    var streetImgs = {
        daymode: website.Base_url('assets/images/leaflet/street.png'),
        nightmode: website.Base_url('assets/images/leaflet/street_night.png')
    };
    var streetStores = [];
    var currentStreetId;
    
    $.ajax({
        url: '<?=site_url('ajax/homepage/get_location')?>',
        dataType: 'json',
        error: function() {
        console.log('ajax error!')
        },
        success: function(data) {

        streetStores = data;
    
        var storeIcons = [];
    
        for(var i=0; i < streetStores.length; i++) {
            // Street Item
            var $streetLink = $('<a></a>').addClass('street_name').attr('href', 'javascript:;').attr('data-streetid', streetStores[i].id).text(streetStores[i].streetName);
            var $streetItem = $('<div></div>').addClass('item').append($streetLink);
            
            // First Street Item
            if(i == 0) {
            $streetItem.addClass('active');
    
            // 顯示街道資料
            streetIntro(streetStores[i]);
            }
    
            // 街道的商店設定
            if( streetStores[i].stores.length !== 0 ) {
            var $storeItems = $('<ul></ul>');
    
            for(j=0; j < streetStores[i].stores.length; j++) {
                var storeicon = (j % 2 == 0 ? "store_icon" : (j % 3 == 0 ? "store_icon_w" : "store_icon_s"));
                // 商店的標點
                var store = streetStores[i].stores[j];
                var diamondhtml = (streetStores[i].stores[j].diamond) ? '<i class="icon_diamond_s"></i>' : '';
                var storeObj = {
                storeId: store.id,
                latlng: store.latlng,
                storeName: store.storeName,
                markerHtml: '<a href="javascript:;" id="'+streetStores[i].stores[j].brandId+'">' +
                    '<i class="' + storeicon + '"></i>' +
                '</a>',
                popupHtml:
                    '<div class="map_popup">' +
                    '<div class="map_popup_inner">' +
                    '<div class="map_popup_head">' +
                    '<a class="brand_name" href="' +
                    store.brandLink +
                    '">' +
                    '<div class="brand_logo">' +
                    '<div class="pic" style="background-image: url(' +
                    store.brandImg +
                    ');">' +
                    '<img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">' +
                    "</div>" +
                    "</div>" +
                    "<h2>" +
                    store.storeName +
                    "</h2>" +
                    "</a>" +
                    '<div class="address">' +
                    "<div>" +
                    "<span>Hi Kate welcome back" +
                    //store.optionID +
                    "</span>" +
                    "</div>" +
                    '<i class="icon_map_marker"></i>' +
                    "<span>" +
                    "No." +
                    store.number +
                    ", " +
                    streetStores[i].streetName +
                    "</span>" +
                    "</div>" +
                    "</div>" +
                    '<div class="map_popup_content">' +
                    '<a class="btn_favorite" data-designerId="02" href="javascript:;"><i class="icon_favorite_heart"></i></a>' +
                    '<div class="intro">' +
                    '<a class="designer_info" href="' +
                    store.designerLink +
                    '">' +
                    '<div class="profile_picture">' +
                    '<div class="pic" style="background-image: url(' +
                    store.designerImg +
                    ')">' +
                    '<img class="size" src="<?= base_url('assets/images/size_1x1.png') ?>">' +
                    "</div>" +
                    "</div>" +
                    '<h3 class="designer_name">' +
                    diamondhtml +
                    '<img class="flag" src="' +
                    store.flag +
                    '">' +
                    '<span class="name">' +
                    store.designerName +
                    "</span>" +
                    //'<div class="divide_line"></div>' +
                    //'<div class="country">' +
                    //'<span class="country">' +
                    //store.country +
                    //"&nbsp;PRODUCTION&nbsp;" +
                    //store.country +
                    //"&nbsp;DESIGN" +
                    //"</span>" +
                    //"</div>" +
                    "</h3>" +
                    "</a>" +
                    //'<div class="brand_name">' +
                    //store.brandName +
                    //"</div>" +
                    '<div id="style-2" class="text">' +
                    store.description +
                    "</div>" +
                    '<a class="btn common more" href="' +
                    store.productsLink +
                    '">' +
                    "Products" +
                    "</a>" +
                    "</div>" +
                    '<div class="picture">' +
                    '<div class="thumb">' +
                    '<div class="pic" style="background-image: url(' +
                    store.brandPic +
                    ')">' +
                    '<img class="size" src="<?= base_url('assets/images/size_4x3.png') ?>">' +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>",
                };
                storeIcons.push(storeObj);
    
                // Aside Store Item
                var $storeLink = $('<a></a>').addClass('store_name').attr('href', 'javascript:;').attr('data-storeid', store.id).text(store.storeName);
                var $storeItem = $('<li></li>').append($storeLink);
                $storeItems.append($storeItem);
            }
    
            // 街道塞入店家
            $streetItem.append($storeItems);
            }
    
            // Street Aside 塞入街道、店家
            $('#streetAside .street_list').append($streetItem);


        }
        
        // 設定地圖、加入商店的標點
        storeMap(streetImgs, storeIcons);
    
        // Street Aside Store List 加入捲軸
        $('#streetAside .street_list').mCustomScrollbar({
            theme: 'dark-3',
            axis: 'y',
            autoHideScrollbar: true
        });
        }
    });
    
    // Street Aside 的 click 設定
    $('#streetAside').on('click', '.open_aside', function(event) {
        $('#streetAside').addClass('isOpen');
    });
    $('#streetAside').on('click', '.close_aside', function (event) {
        $('#streetAside').removeClass('isOpen');
    });
    $('#streetAside .street_list').on('click', '.street_name', function (event) {
        $(this).parent('.item').siblings('.item').children('ul').stop().slideUp(function(event) {
        $(this).parent('.item').removeClass('active');
        });
        $(this).parent('.item').children('ul').stop().slideDown(function(event) {
        $(this).parent('.item').addClass('active');
        });
    
        var streetid = $(this).attr('data-streetId');
        if(streetid !== currentStreetId) {
        $.each(streetStores, function(i, item) {
            if( item.id == streetid ) {
            $('#streetStores .stores_slider').slick('unslick');
            $('#streetStores .stores_slider').empty();
            streetIntro(streetStores[i]);
            }
        });
        }
    });
    
    // 街道資料的顯示、切換
    function streetIntro(streetData) {
        currentStreetId = streetData.id;
    
        // Street Intro
        $('#streetStores .street_intro h2').text(streetData.streetName);
        $('#streetStores .street_intro h3').text(streetData.style);
        $('#streetStores .street_intro .text').text(streetData.streetDescription);
    
        // Street Stores Slider
        $('#streetStores .stores_slider').slick({
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
            breakpoint: 1280,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 560,
            settings: {
                centerMode: true,
                centerPadding: '44px',
                slidesToShow: 1,
                slidesToScroll: 1
            }
            },
            {
            breakpoint: 370,
            settings: {
                centerMode: true,
                centerPadding: '20px',
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
        ]
        });
    
        for(var i=0; i < streetData.stores.length; i++) {
        var diamondhtml = (streetData.stores[i].diamond) ? '<i class="icon_diamond_s"></i>' : '';
        var slidehtml = '<div class="slide">' +
            '<a class="thumb" href="' + streetData.stores[i].productsLink + '">' +
            '<div class="pic" style="background-image: url(' + streetData.stores[i].brandPic + ');">' +
                '<img class="size" src="'+website.Base_url('assets/images/size_1x1.png')+'" />' +
            '</div>' +
            '</a>' +
            '<div class="intro">' +
            '<h3 class="store_name">' +
                '<a href="' + streetData.stores[i].brandLink + '">' + streetData.stores[i].storeName + '</a>' +
            '</h3>' +
            '<a class="designer_info" href="' + streetData.stores[i].designerLink + '">' +
                '<div class="profile_picture">' +
                '<div class="pic" style="background-image: url(' + streetData.stores[i].designerImg + ')">' +
                    '<img class="size" src="'+website.Base_url('assets/images/size_1x1.png')+'" />' +
                '</div>' +
                '</div>' +
                '<div class="designer_name">' +
                diamondhtml +
                '<img class="flag" src="' + streetData.stores[i].flag + '" />' +
                '<span>' + streetData.stores[i].designerName + '</span>' +
                '</div>' +
            '</a>' +
            '</div>' +
        '</div>';
    
        $('#streetStores .stores_slider').slick('slickAdd', slidehtml);
        }
    }
    
    // OOTD 加入愛心的點擊事件
    $(document).on('click', '.btn_favorite', function(event) {
        // ootdId 取得穿搭的 ID
        var ootdId = $(this).attr('data-ootdId');
    
        if ($(this).hasClass('active')) {
        // 取消最愛寫這裡
    
        $(this).removeClass('active');
        } else {
        // 加入最愛寫這裡
    
        $(this).addClass('active');
        }
    });
    }); 



    // Open a URL in a lightbox
    var lightbox = lity(
      "//www.youtube.com/embed/-pPHyof98kk?rel=0&autoplay=1"
    );

    // Bind as an event handler
    $(document).on("click", "[data-lightbox]", lity);

    $('body').on('click','.btn_search_map',function(){
        $('html, body').animate({
            scrollTop: $("#storeMap").offset().top
        }, 1000);
        $('#'+$(this).data('brandid')).parents('.leaflet-marker-icon').trigger('click');

    });
</script>
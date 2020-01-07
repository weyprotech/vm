function storeMap(streetImg, storeIcons) {
  var storeMap = L.map('storeMap', {
    zoomControl: false,
    fullscreenControl: true,
    minZoom: 1,
    maxZoom: 3,
    continuousWorld: false,
    noWrap: true,
    crs: L.CRS.Simple,
    attributionControl: false,
    scrollWheelZoom: false
  });

  L.control.zoom({
    position: 'topright'
  }).addTo(storeMap);

  var bounds = new L.LatLngBounds(
    storeMap.unproject([0, 2500], storeMap.getMaxZoom()),
    storeMap.unproject([5200, 0], storeMap.getMaxZoom())
  );

  var centerPosition = [
    storeMap.unproject([0, 950], storeMap.getMaxZoom()).lat,
    storeMap.unproject([2600, 0], storeMap.getMaxZoom()).lng
  ]

  storeMap.setMaxBounds(bounds);
  storeMap.setView(centerPosition, 2);

  L.control.attribution({
    prefix: false
  }).addAttribution('Design by Weypro.').addTo(storeMap);

  L.imageOverlay(streetImg, bounds).addTo(storeMap);

  // Icon
  var storeMarkers = [];
  var LeafDivIcon = L.DivIcon.extend({
    options: {
      iconSize: [14, 14],
      iconAnchor: [0, 0],
      popupAnchor: [7, 7],
      tooltipAnchor: [7, 7],
      className: 'store_mark'
    }
  });
  for (var i = 0; i < storeIcons.length; i++) {
    var markerPosition = [
      storeMap.unproject([0, storeIcons[i].latlng[0]], storeMap.getMaxZoom()).lat,
      storeMap.unproject([storeIcons[i].latlng[1], 0], storeMap.getMaxZoom()).lng
    ];

    var popup = L.responsivePopup().setContent(storeIcons[i].popupHtml);
    var storeMarker = new L.marker(markerPosition, {
      icon: new LeafDivIcon({
        html: storeIcons[i].markerHtml
      })
    })
    .bindTooltip(storeIcons[i].storeName)
    .bindPopup(popup, { maxWidth: 'auto' })
    .addTo(storeMap)
    .on('popupopen', function (e) {
      $(e.target._icon).addClass('isPopup');
      $('.map_popup_inner').mCustomScrollbar({
        theme: 'dark-3',
        axis: 'y'
      });
    })
    .on('popupclose', function (e) {
      $(e.target._icon).removeClass('isPopup');
    });;

    storeMarkers.push(storeMarker);
  }

  // Zoom
  $('#mapControls').on('click', '.zoomOut', function() {
    storeMap.setZoom(storeMap.getZoom() - 1);
  });
  $('#mapControls').on('click', '.zoomIn', function () {
    storeMap.setZoom(storeMap.getZoom() + 1);
  });
  storeMap.on('zoomend', function () {
    var currentZoom = storeMap.getZoom(),
        sizeMultiple,
        fontSize;

    if (currentZoom == 2) {
      sizeMultiple = 1;
      fontSize = '0.75rem';
      changeMarkSize(sizeMultiple, fontSize, '');
    } else if (currentZoom > 2) {
      sizeMultiple = Math.pow(2, currentZoom - 2);
      fontSize = 0.75 * sizeMultiple + 'rem';
      changeMarkSize(sizeMultiple, fontSize, 'larger');
    } else if (currentZoom < 2) {
      sizeMultiple = Math.pow(2, 2 - currentZoom);
      fontSize = 0.75 / sizeMultiple + 'rem';
      changeMarkSize(sizeMultiple, fontSize, 'smaller');
    }
  });
  function changeMarkSize(sizeMultiple, fontSize, status) {
    var baseSizeNum = 14;
    var size = [];
    var popAnchor = [];
    var tipAnchor = [];

    if (status == '') {
      size = [baseSizeNum, baseSizeNum];
      popAnchor = [baseSizeNum * 0.5, baseSizeNum * 0.5];
      tipAnchor = [baseSizeNum * 0.5, baseSizeNum * 0.5];
    } else if (status == 'larger') {
      size = [baseSizeNum * sizeMultiple, baseSizeNum * sizeMultiple];
      popAnchor = [baseSizeNum * sizeMultiple * 0.5, baseSizeNum * sizeMultiple * 0.5];
      tipAnchor = [baseSizeNum * sizeMultiple * 0.5, baseSizeNum * sizeMultiple * 0.5];
    } else if (status == 'smaller') {
      size = [baseSizeNum / sizeMultiple, baseSizeNum / sizeMultiple];
      popAnchor = [baseSizeNum / sizeMultiple * 0.5, baseSizeNum / sizeMultiple * 0.5];
      tipAnchor = [baseSizeNum / sizeMultiple * 0.5, baseSizeNum / sizeMultiple * 0.5];
    }
    for (var i = 0; i < storeIcons.length; i++) {
      storeMarkers[i].setIcon(new LeafDivIcon({
        iconSize: size,
        iconAnchor: [0, 0],
        popupAnchor: popAnchor,
        tooltipAnchor: tipAnchor,
        html: storeIcons[i].markerHtml
      }));
    }

    $('.store_mark').find('.store_name').css('font-size', fontSize);
  }

  // Ctrl + Mousewheel
  var scrollWhellTime;
  $('#storeMap').on('mousewheel DOMMouseScroll', function (event) {
    event.stopPropagation();

    if (event.ctrlKey == true) {
      event.preventDefault();
      storeMap.scrollWheelZoom.enable();
      $('#storeMap').removeClass('map_scroll');
      setTimeout(function () {
        storeMap.scrollWheelZoom.disable();
      }, 1000);
    } else {
      storeMap.scrollWheelZoom.disable();
      $('#storeMap').addClass('map_scroll');
      clearTimeout(scrollWhellTime);
      scrollWhellTime = setTimeout(function () {
        $('#storeMap').removeClass('map_scroll');
      }, 600);
    }
  });
  $(window).on('mousewheel DOMMouseScroll', function (event) {
    $('#storeMap').removeClass('map_scroll');
  })

  // Mode Change
  $('#mapMode').on('change', 'input:radio[name="mapMode"]', function() {
    if ($('input:radio[name="mapMode"]:checked').hasClass('switch_off')) {
      $('.store_map_wrapper').removeClass('night_mode');
    } else if ($('input:radio[name="mapMode"]:checked').hasClass('switch_on')) {
      $('.store_map_wrapper').addClass('night_mode');
    }
  })

  // Aside
  $('#streetAside').on('click', '.open_aside', function(e) {
    $('#streetAside').addClass('isOpen');
  });
  $('#streetAside').on('click', '.close_aside', function (e) {
    $('#streetAside').removeClass('isOpen');
  });
  $('#streetAside .street_list').on('click', '.street_name', function (e) {
    $(this).parent('.item').siblings('.item').children('ul').stop().slideUp(function(e) {
      $(this).parent('.item').removeClass('active')
    });
    $(this).parent('.item').children('ul').stop().slideDown(function(e) {
      $(this).parent('.item').addClass('active')
    });
  });

  // Slider
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

  // Resize
  $(window).on('resize', function() {
    storeMap.closePopup();
  });
}
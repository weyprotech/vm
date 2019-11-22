function storeMap(streetImg, storeIcons) {
  var storeMap = L.map('storeMap', {
    minZoom: 1,
    maxZoom: 3,
    continuousWorld: false,
    noWrap: true,
    crs: L.CRS.Simple,
    attributionControl: false,
    scrollWheelZoom: false
  });

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
      className: 'store_mark'
    }
  });
  for (var i = 0; i < storeIcons.length; i++) {
    var storeMarker = new L.marker(storeIcons[i].latlng, {
      icon: new LeafDivIcon({
        html: storeIcons[i].html
      })
    }).addTo(storeMap);
    storeMarkers.push(storeMarker);
  }

  // Mark Click
  $(document).on(clickHandler, '.store_mark a', function () {
    alert($(this).data('storeid'));
  });

  // Zoom
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
    var baseSizeNum = 90;
    var size;
    if (status == '') {
      size = [baseSizeNum, baseSizeNum];
    } else if (status == 'larger') {
      size = [baseSizeNum * sizeMultiple, baseSizeNum * sizeMultiple];
    } else if (status == 'smaller') {
      size = [baseSizeNum / sizeMultiple, baseSizeNum / sizeMultiple];
    }
    for (var i = 0; i < storeIcons.length; i++) {
      storeMarkers[i].setIcon(new LeafDivIcon({
        iconSize: size,
        html: storeIcons[i].html
      }));
    }
    $('.store_mark').find('.store_name').css('font-size', fontSize);
  }

  // ctrl + mousewheel
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
}
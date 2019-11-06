var windowWidth = $(window).width();
var clickHandler = ('ontouchstart' in document.documentElement ? 'touchstart' : 'click');

$(document).ready(function () {
  $('.retina').retina();

  // Sticky
  sticky();

  // Sidebar
  $('#sidebar').sidebar({
    side: 'left'
  });
  $('#sidebar').on('sidebar:closed', function () {
    $('#btn_menu').removeClass('active');
    $('.sidebar_menu ul').find('a.active').next('ul').css('display', '');
    $('.sidebar_menu ul').find('a.active').removeClass('active');
  });
  $('#btn_menu').on(clickHandler, function (event) {
    event.preventDefault();
    $(this).toggleClass('active');
    $('#sidebar').trigger('sidebar:toggle').toggleClass('active');
  });
  $('.sidebar_menu ul li a').on(clickHandler, function () {
    var href = $(this).attr('href');

    if ($(this).siblings('ul').length > 0) {
      event.preventDefault();
      if ($(this).hasClass('active')) {
        if (href !== 'javascript:;' || href !== '#') {
          window.location.href = href;
        }
      } else {
        $(this).addClass('active').siblings('ul').stop().slideDown();
        $(this).parent('li').siblings('li').find('a.active').next('ul').stop().slideUp(function() {
          $(this).prev('a.active').removeClass('active');
        });
      }
    }
  });

  //Nav
  $('.head_nav ul li').on('mouseenter', function (event) {
    $(this).children('a').addClass('active');
    if ($(this).children('ul').length > 0) {
      $(this).children('ul').stop().slideDown('250', function () {
        $(this).addClass('active');
      });
    }
  });
  $('.head_nav ul li').on('mouseleave', function (event) {
    $(this).children('a').removeClass('active');
    if ($(this).children('ul').length > 0) {
      $(this).children('ul').stop().slideUp('250', function () {
        $(this).removeClass('active');
      });
    }
  });

  // Captcha Size
  if ($('.captcha').length > 0) {
    scaleCaptcha();
  }

  // Header Search
  $('#header').on(clickHandler, '.option_search a', function(event) {
    event.preventDefault();
    $('#header .header_search').stop().slideToggle();
  });
  $(document).on(clickHandler, function(event) {
    if (!$(event.target).is('#header .option_search a, #header .option_search a *, #header .header_search, #header .header_search *') && windowWidth < 1024) {
      $('#header .header_search').stop().slideUp();
    }
  });

  // Cart Drop
  $('#header').on(clickHandler, '.option_cart a.cart_toggle', function (event) {
    event.preventDefault();
    $('#header .option_cart .cart_drop').stop().slideToggle();
  });
  $(document).on(clickHandler, function (event) {
    if (!$(event.target).is('#header .option_cart, #header .option_cart *')) {
      $('#header .option_cart .cart_drop').stop().slideUp();
    }
  });

  // Slick Slider
  if ($('.top_designers_slider').length > 0) {
    $('.top_designers_slider').slick({
      speed: 500,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 1280,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3
          }
        },
        {
          breakpoint: 960,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 560,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
  }
  if ($('.ads_banner').length > 0) {
    $('.ads_banner').slick({
      arrows: false,
      //autoplay: true,
      autoplaySpeed: 5000,
      dots: true,
      speed: 500
    });
  }

  // Custom Scroll
  if ($('.what_next_main').length > 0) {
    $('.what_next_main').mCustomScrollbar({
      theme: 'dark-3',
      axis: 'x'
    });
  }

  // Masonry
  if ($('.ootd_list').length > 0) {
    var $ootdList = $('.ootd_list').masonry({
      temSelector: '.item',
      columnWidth: '.grid_sizer',
      gutter: '.gutter_sizer',
      percentPosition: true,
      visibleStyle: { transform: 'translateY(0)', opacity: 1 },
      hiddenStyle: { transform: 'translateY(100px)', opacity: 0 }
    });

    $ootdList.imagesLoaded().progress(function () {
      $ootdList.masonry('layout');
    });
  }

  // Popup Close
  // $(document).on(clickHandler, '.popup-modal-dismiss', function (event) {
  //   event.preventDefault();
  //   $.magnificPopup.close();
  // });

  // Tab - jquery.tabber.js
  // $('.tabber_wrapper').tabber();

  // Fit Vidos - jquery.fitvids.js
  // $('#wrapper').fitVids();

  // Body Scroll
  // $(window).scroll(function () {
  //   $('[data-anchor]').each(function (index, el) {
  //     var scrolltop = $(window).scrollTop(),
  //       position = $(this).offset().top,
  //       headerH = $('#header').outerHeight(true),
  //       selfH = $(this).outerHeight(true),
  //       anchor = $(this).attr('data-anchor');

  //     if (scrolltop >= position - headerH - 5 && scrolltop <= position - headerH + selfH - 5) {
  //       $('#stickyNav ul a.active').removeClass('active');
  //       $('#stickyNav ul a[href="#' + anchor + '"]').addClass('active');
  //     } else {
  //       $('#stickyNav ul a[href="#' + anchor + '"]').removeClass('active');
  //     }
  //   });
  // });

  // Back to top
  if ($('#backTop').length > 0) {
    $('#backTop').on(clickHandler, function (event) {
      event.preventDefault();
      $('html, body').stop().animate({
        scrollTop: 0
      }, 500, 'swing');
    });
    $(window).on('scroll', function () {
      if ($(window).scrollTop() > 100) {
        $('#backTop').stop().fadeIn(400, function () {
          $(this).css('display', 'block');
        });
      } else {
        $('#backTop').stop().fadeOut(400);
      }
    });
  }

  // Block Link
  $('a[href*="#"]')
    .not('[href="#"]')
    .not('[href="#0"]')
    .on(clickHandler, function (event) {
      if (
        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
        location.hostname == this.hostname
      ) {
        var url = $(this).attr('href');
        var hashName = url.split('#')[1];
        var $target = $('[data-anchor="' + hashName + '"]');

        if ($target.length > 0) {
          $('html, body').stop().animate({
            scrollTop: $target.offset().top - $('#header').outerHeight()
          }, 800);
        }
      }
    });
});

// Resize
$(window).on('resize', function () {
  if (windowWidth != $(window).width()) {
    windowWidth = $(window).width();

    // reSetting
    $('#header .header_search').css('display', '');

    // Sticky
    $('#header').unstick();
    $('#header .header_nav_wrap').unstick();
    sticky();

    // Captcha
    if ($('.captcha').length > 0) {
      scaleCaptcha();
    }
  }
});

$(window).on('load', function () {
  // Link
  var url = window.location.toString();
  var hashName = url.split('#')[1];
  var $target = $('[data-anchor="' + hashName + '"]');

  if ($target.length > 0) {
    console.log
    // Reset where animation starts.
    $('html, body').scrollTop(0);
    // Animate to
    $('html, body').stop().animate({
      scrollTop: $target.offset().top - $('#header').outerHeight()
    }, 800);
  }
});

$(window).on('hashchange', function () {
  var hash = window.location.hash;
  var hashName = hash.split('#')[1];
  var $target = $('[data-anchor="' + hashName + '"]');

  if ($target.length > 0) {
    $('html, body').stop().animate({
      scrollTop: $target.offset().top - $('#header').outerHeight()
    }, 800);
  }
});

function sticky() {
  if (windowWidth >= 1024) {
    $('#header .header_nav_wrap').sticky({
      topSpacing: 0,
      zIndex: 99
    });
  } else if (windowWidth < 1024) {
    $('#header').sticky({
      topSpacing: 0,
      zIndex: 99
    });
    $('#header').on('sticky-start', function () {
      $('#sidebar').addClass('head_sticky');
    });
    $('#header').on('sticky-end', function () {
      $('#sidebar').removeClass('head_sticky');
    });
  }
}

//use width google reCaptcha
function scaleCaptcha() {
  var reCaptchaWidth = 304;
  var reCaptchaHeight = 78;
  var containerWidth = $('.captcha').width();

  if (reCaptchaWidth > containerWidth) {
    var captchaScale = containerWidth / reCaptchaWidth;
    $('.captcha_inner').css({
      'transform': 'scale(' + captchaScale + ')'
    });
    $('.captcha').css({
      'width': reCaptchaWidth * captchaScale + 'px',
      'height': reCaptchaHeight * captchaScale + 'px'
    });
  } else {
    $('.captcha_inner').css({
      'transform': ''
    });
    $('.captcha').css({
      'width': '',
      'height': ''
    });
  }
}
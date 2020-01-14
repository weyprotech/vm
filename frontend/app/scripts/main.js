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
    $('.sidebar_menu > ul > li > a.active').next('.sub_menu').css('display', '');
    $('.sidebar_menu > ul > li > a.active').removeClass('active');
  });
  $('#btn_menu').on(clickHandler, function (event) {
    event.preventDefault();
    $(this).toggleClass('active');
    $('#sidebar').trigger('sidebar:toggle').toggleClass('active');
  });
  $('.sidebar_menu > ul > li > a').on(clickHandler, function (event) {
    var href = $(this).attr('href');

    if ($(this).siblings('.sub_menu').length > 0) {
      event.preventDefault();
      
      if ($(this).hasClass('active')) {
        if (href == 'javascript:;' || href == '#') {
          $(this).removeClass('active').next('.sub_menu').stop().slideUp();
        } else {
          window.location.href = href;
        }
      } else if (!$(this).hasClass('active')) {
        $(this).addClass('active').siblings('.sub_menu').stop().slideDown();
        $(this).parent('li').siblings('li').find('a.active').next('.sub_menu').stop().slideUp(function () {
          $(this).prev('a.active').removeClass('active');
        });
      }
    }
  });

  // Nav
  $('.header_nav > ul > li').on('mouseenter', function (event) {
    $(this).children('a').addClass('active');
    if ($(this).children('.sub_menu').length > 0) {
      $(this).children('.sub_menu').stop().animate({ height: 'show', opacity: 1 }, '500');
    }
  });
  $('.header_nav > ul > li').on('mouseleave', function (event) {
    $(this).children('a').removeClass('active');
    if ($(this).children('.sub_menu').length > 0) {
      $(this).children('.sub_menu').stop().animate({ height: 'hide', opacity: 0 }, '300');
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
      autoplay: true,
      autoplaySpeed: 5000,
      dots: true,
      speed: 500
    });
  }
  if ($('.aside_products_slider').length > 0) {
    $('.aside_products_slider').slick({
      speeed: 500,
      slidesToShow: 3,
      swipeToSlide: true,
      vertical: true,
      verticalSwiping: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            centerMode: true,
            centerPadding: '20px',
            slidesToShow: 3,
            vertical: false,
            verticalSwiping: false,
          }
        },
        {
          breakpoint: 660,
          settings: {
            centerMode: true,
            centerPadding: '30px',
            slidesToShow: 2,
            vertical: false,
            verticalSwiping: false,
          }
        },
        {
          breakpoint: 480,
          settings: {
            centerMode: true,
            centerPadding: '45px',
            slidesToShow: 1,
            vertical: false,
            verticalSwiping: false,
          }
        }
      ]
    })
  }
  if ($('.list_slider_wrapper').length > 0) {
    $('.list_slider_wrapper .list_slider').slick({
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
  if ($('.banner_slider').length > 0) {
    $('.banner_slider').slick({
      arrows: false,
      autoplay: true,
      autoplaySpeed: 5000,
      dots: true,
      speed: 500
    });
  }

  // Custom Scroll
  if ($('.scrollbar_x').length > 0) {
    $('.scrollbar_x').mCustomScrollbar({
      theme: 'dark-3',
      axis: 'x'
    });
  }
  if ($('.scrollbar_y').length > 0) {
    $('.scrollbar_y').mCustomScrollbar({
      theme: 'dark-3',
      axis: 'y'
    });
  }
  if ($('.topping_block .topping_list').length > 0) {
    topping_list_scroll();
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

    $ootdList.imagesLoaded().progress(function() {
      $ootdList.masonry('layout');
    });
  }
  if ($('.brandStory_wall').length > 0) {
    var $brandStoryWall = $('.brandStory_wall').masonry({
      temSelector: '.item',
      columnWidth: '.grid_sizer',
      gutter: '.gutter_sizer',
      percentPosition: true,
      visibleStyle: { transform: 'translateY(0)', opacity: 1 },
      hiddenStyle: { transform: 'translateY(100px)', opacity: 0 }
    });

    $brandStoryWall.imagesLoaded().progress(function() {
      $brandStoryWall.masonry('layout');
    });
  }

  // Social Share
  if ($('.share_links').length > 0) {
    var localUrl = window.location.href;
    var localTitle = document.title;

    $('.share_links').find('a').each(function() {
      if ($(this).hasClass('facebook')) {
        $(this).attr('href', 'https://www.facebook.com/sharer.php?u=' + localUrl);
      } else if ($(this).hasClass('pinterest')) {
        $(this).attr('href', 'http://pinterest.com/pin/create/link/?url=' + localUrl);
      } else if ($(this).hasClass('twitter')) {
        $(this).attr('href', 'https://twitter.com/intent/tweet?url=' + localUrl + '&text=' + localTitle);
      } else if ($(this).hasClass('weibo')) {
        $(this).attr('href', 'http://service.weibo.com/share/share.php?url=' + localUrl + '&title=' + localTitle);
      }
    });
  }

  // Comments
  if ($('.comments_block').length > 0) {
    $('.comments_block').on(clickHandler, '.comments_title', function() {
      $(this).toggleClass('active').next('.comments_content').stop().slideToggle();
    });
  }

  // Designer Header
  if ($('.designer_header').length > 0) {
    $('.designer_navigation .nav_menu').on(clickHandler, '.toggle_menu', function(event) {
      $(this).siblings('ul').stop().slideToggle(function(event) {
        $(this).parent('.nav_menu').toggleClass('open');
        if ( !$(this).parent('.nav_menu').hasClass('open') ) {
          $(this).find('a').removeClass('active');
          $(this).find('ul').stop().hide();
        }
      });
    })
    $('.designer_navigation .nav_menu ul').on(clickHandler, 'a', function(event) {
      $(this).siblings('ul').slideToggle(function(event) {
        $(this).siblings('a').toggleClass('active');
      });
    });
    $(document).on(clickHandler, function (event) {
      if (!$(event.target).is('.designer_navigation .nav_menu, .designer_navigation .nav_menu *') && windowWidth >= 1024) {
        $('.designer_navigation .nav_menu ul').find('a.active').removeClass('active').siblings('ul').stop().slideUp();
      }
    });
  }

  // Fit Vidos - jquery.fitvids.js
  $('.fit_video').fitVids();

  // Popup
  $('.popup').magnificPopup({
    type: 'ajax',
    callbacks: {
      ajaxContentAdded: function() {
        if ($('.fit_video').length > 0) {
          $('.fit_video').fitVids();
        }
      }
    }
  });
  // $(document).on(clickHandler, '.popup-modal-dismiss', function (event) {
  //   event.preventDefault();
  //   $.magnificPopup.close();
  // });

  // Tab - jquery.tabber.js
  // $('.tabber_wrapper').tabber();

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

  // Fixed Buttons
  if ($('#fixedButtons').length > 0) {
    $(window).on('scroll', function () {
      if ($(window).scrollTop() > 100) {
        $('#fixedButtons').fadeIn(400, function () {
          $(this).css('display', 'block');
        });
      } else {
        $('#fixedButtons').fadeOut(400);
      }
    });
  }
  if ($('#backTop').length > 0) {
    $('#backTop').on(clickHandler, function (event) {
      event.preventDefault();
      $('html, body').stop().animate({
        scrollTop: 0
      }, 500, 'swing');
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
    topping_list_scroll();

    // Sticky
    $('#header').unstick();
    $('#header .header_nav_wrap').unstick();
    sticky();

    // Custom Scroll
    if ($('.scrollbar_x').length > 0) {
      $('.scrollbar_x').mCustomScrollbar('destroy');
      $('.scrollbar_x').mCustomScrollbar({
        theme: 'dark-3',
        axis: 'x'
      });
    }

    // Designer Header
    if ($('.designer_header').length > 0) {
      $('.designer_header .nav_menu').removeClass('open');
      $('.designer_header .nav_menu ul').css('display', '');
      $('.designer_header .nav_menu ul a').removeClass('active');
    }

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

function topping_list_scroll() {
  if (windowWidth >= 768) {
    $('.topping_block .topping_list').mCustomScrollbar({
      theme: 'dark-3',
      axis: 'y'
    });
  } else if(windowWidth < 768) {
    $('.topping_block .topping_list').mCustomScrollbar('destroy');
  }
}
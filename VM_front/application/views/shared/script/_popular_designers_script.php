<script>
      $(function() {
        // Designer Slider
        var designerSlider = $('.designers_slider');
        
        designerSlider.on('init', function(event, slick, currentSlide) {
          var cur = $(slick.$slides[slick.currentSlide]),
          next = cur.next(),
          prev = cur.prev();
          prev.addClass('slick-sprev');
          next.addClass('slick-snext');
          cur.removeClass('slick-snext').removeClass('slick-sprev');
          slick.$prev = prev;
          slick.$next = next;
        }).on('beforeChange', function(event, slick, currentSlide, nextSlide) {
          var cur = $(slick.$slides[nextSlide]);
          slick.$prev.removeClass('slick-sprev');
          slick.$next.removeClass('slick-snext');
          next = cur.next(),
          prev = cur.prev();
          prev.prev();
          prev.next();
          prev.addClass('slick-sprev');
          next.addClass('slick-snext');
          slick.$prev = prev;
          slick.$next = next;
          cur.removeClass('slick-next').removeClass('slick-sprev');
        });
      
        designerSlider.slick({
          speed: 800,
          arrows: true,
          dots: false,
          focusOnSelect: true,
          infinite: true,
          centerMode: true,
          slidesPerRow: 1,
          slidesToShow: 1,
          slidesToScroll: 1,
          centerPadding: '0',
          swipe: true
        });
      
        // favorite 加入愛心的點擊事件
        $(document).on('click', '.btn_favorite', function() {
          // designerId 取得穿搭的 ID
          var designerId = $(this).attr('data-designerId');
      
          if ($(this).hasClass('active')) {
            // 取消最愛寫這裡
      
            $(this).removeClass('active');
          } else {
            // 加入最愛寫這裡
      
            $(this).addClass('active');
          }
        });
      });
    </script>
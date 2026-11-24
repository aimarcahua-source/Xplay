jQuery(function ($) {
    function updatePostCarousel() {
        $('.post-carousel-banner').each(function () {
            var $slider = $(this);
            // Make sure Slick is already initialized
            if (!$slider.hasClass('slick-initialized')) {
                return;
            }
            // Desktop: show 3 posts
            $slider.slick('slickSetOption', 'slidesToShow', 3, true);
            $slider.slick('slickSetOption', 'slidesToScroll', 3, true);
            // Keep mobile as 1 post
            $slider.slick('slickSetOption', 'responsive', [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                }
            ], true);
            // Recalculate Slick layout.
            $slider.slick('setPosition');
        });
    }
    // Parent theme initializes Slick first.
    setTimeout(function () {
        updatePostCarousel();
    }, 100);
});
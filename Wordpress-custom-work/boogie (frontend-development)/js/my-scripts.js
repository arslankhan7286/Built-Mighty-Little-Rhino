/*========== Back to Top =========*/

var $backToTop = $(".back-to-top");
$backToTop.hide();
$(window).on('scroll', function() {
    if ($(this).scrollTop() > 100) {
        $backToTop.fadeIn();
    } else {
        $backToTop.fadeOut();
    }
});
$backToTop.on('click', function(e) {
    $("html, body").animate({
        scrollTop: 0
    }, 500);
});


if($(window).width() <= 480){
    $('.cart_img').append($('.cart_qty').html());
  }



/*========== Back to Top End=========*/


/*========== Best Seller=========*/

$('.best_seller').slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 1000,
    slidesToShow: 4,
    variableWidth: false,
    appendArrows: ".p_sec_1",
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
    slidesToScroll: 2,
    responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
                centerMode: true,
                arrows: false,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 360,
            settings: {
                slidesToShow: 2,
                centerMode: true,
                arrows: false,
                slidesToScroll: 1,
            }
        }
    ]
});

/*========== Best Seller End=========*/

/*========== Donults =========*/

$('.donults').slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 1000,
    slidesToShow: 4,
    variableWidth: false,
    appendArrows: ".p_sec_2",
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
    slidesToScroll: 2,
    responsive: [{
        breakpoint: 768,
        settings: {
            slidesToShow: 2,
            centerMode: true,
            arrows: false,
            slidesToScroll: 1,
        }
    },
    {
        breakpoint: 360,
        settings: {
            slidesToShow: 2,
            centerMode: true,
            arrows: false,
            slidesToScroll: 1,
        }
    }
]
});

/*========== Donults End=========*/


/*========== Begels Start=========*/

$('.bagels').slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 1000,
    slidesToShow: 4,
    variableWidth: false,
    appendArrows: ".p_sec_3",
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
    slidesToScroll: 2,
    responsive: [{
        breakpoint: 768,
        settings: {
            slidesToShow: 2,
            centerMode: true,
            arrows: false,
            slidesToScroll: 1,
        }
    },
    {
        breakpoint: 360,
        settings: {
            slidesToShow: 2,
            centerMode: true,
            arrows: false,
            slidesToScroll: 1,
        }
    }
]
});

/*========== Begels End=========*/




$('.related').slick({
    mobileFirst: true,
    dots: false,
    infinite: true,
    arrows: true,
    speed: 1000,
    slidesToShow: 4,
    variableWidth: false,
    appendArrows: ".p_sec_3",
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
    slidesToScroll: 2,
    responsive: [{
        breakpoint: 768,
        settings: {
            slidesToShow: 4,
            centerMode: true,
            arrows: false,
            slidesToScroll: 1,
        }
    },
    {
        breakpoint: 360,
        settings: {
            slidesToShow: 2,
            centerMode: true,
            arrows: false,
            slidesToScroll: 1,
        }
    }
]
});
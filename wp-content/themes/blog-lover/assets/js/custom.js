// jQuery(document).ready(function($) {
//     $( document.body ).on( 'post-load', function () {
//         $( '.infinite-loader' ).remove();
//     } );
// /*------------------------------------------------
//             DECLARATIONS
// ------------------------------------------------*/

//     var loader = $('#loader');
//     var loader_container = $('#preloader');
//     var scroll = $(window).scrollTop();  
//     var scrollup = $('.backtotop');
//     var menu_toggle = $('.menu-toggle');
//     var dropdown_toggle = $('.main-navigation button.dropdown-toggle');
//     var nav_menu = $('.main-navigation ul.nav-menu');
//     var featured_slider = $('.featured-slider-wrapper');
//     var testimonial_slider = $('.testimonial-slider');
//     var masonry_gallery = $('.grid');

// /*------------------------------------------------
//             PRELOADER
// ------------------------------------------------*/

//     loader_container.delay(1000).fadeOut();
//     loader.delay(1000).fadeOut("slow");

// /*------------------------------------------------
//             BACK TO TOP
// ------------------------------------------------*/

//     $(window).scroll(function() {
//         if ($(this).scrollTop() > 1) {
//             scrollup.css({bottom:"25px"});
//         } 
//         else {
//             scrollup.css({bottom:"-100px"});
//         }
//     });

//     scrollup.click(function() {
//         $('html, body').animate({scrollTop: '0px'}, 800);
//         return false;
//     });

// /*------------------------------------------------
//             MAIN NAVIGATION
// ------------------------------------------------*/

//     menu_toggle.click(function(){
//         nav_menu.slideToggle();
//        $('.main-navigation').toggleClass('menu-open');
//        $('.menu-overlay').toggleClass('active');
//     });

//     dropdown_toggle.click(function() {
//         $(this).toggleClass('active');
//        $(this).parent().find('.sub-menu').first().slideToggle();
//     });

//     $('.main-navigation ul li.search-menu a').click(function(event) {
//         event.preventDefault();
//         $(this).toggleClass('search-active');
//         $('.main-navigation #search').fadeToggle();
//         $('.main-navigation .search-field').focus();
//     });

//     $(document).keyup(function(e) {
//         if (e.keyCode === 27) {
//             $('.main-navigation ul li.search-menu a').removeClass('search-active');
//             $('.main-navigation #search').fadeOut();
//         }
//     });

//     $(document).click(function (e) {
//         var container = $("#masthead");
//         if (!container.is(e.target) && container.has(e.target).length === 0) {
//             $('#site-navigation').removeClass('menu-open');
//             $('#primary-menu').slideUp();
//             $('.menu-overlay').removeClass('active');
//             $('.main-navigation ul li.search-menu a').removeClass('search-active');
//             $('.main-navigation #search').fadeOut();
//         }
//     });

//     $(window).scroll(function() {
//         if ($(this).scrollTop() > 1) {
//             $('.menu-sticky #masthead').addClass('nav-shrink');
//         }
//         if ($(this).scrollTop() > 50) {
//             $('.menu-sticky #masthead').css({ 'box-shadow' : '0 1px rgba(34, 34, 34, 0.1)' });
//         }
//         else {
//             $('.menu-sticky #masthead').removeClass('nav-shrink');
//             $('.menu-sticky #masthead').css({ 'box-shadow' : 'none' });
//         }
//     });

// /*------------------------------------------------
//             SLICK SLIDER
// ------------------------------------------------*/

//     featured_slider.slick();
//     testimonial_slider.slick();

//     $('.testimonial-slider .slick-dots').insertAfter('.testimonial-slider .entry-container .entry-content');

// /*------------------------------------------------
//             MATCH HEIGHT
// ------------------------------------------------*/

// $('#services-section .entry-header').matchHeight();
// $('#projects-section article .entry-container').matchHeight();

// /*------------------------------------------------
//             MASONRY GALLERY
// ------------------------------------------------*/

// masonry_gallery.packery({ itemSelector: '.grid-item' });

// /*------------------------------------------------
//                 END JQUERY
// ------------------------------------------------*/

// });


jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var loader = $('#loader');
    var loader_container = $('#preloader');
    var scroll = $(window).scrollTop();  
    var scrollup = $('.backtotop');
    var menu_toggle = $('.menu-toggle');
    var dropdown_toggle = $('.main-navigation button.dropdown-toggle');
    var nav_menu = $('.main-navigation ul.nav-menu');
    var featured_slider = $('#featured-slider');
    var regular = $('.regular');

/*------------------------------------------------
            PRELOADER
------------------------------------------------*/

    loader_container.delay(1000).fadeOut();
    loader.delay(1000).fadeOut("slow");

/*------------------------------------------------
                BACK TO TOP
------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
                MENU, STICKY MENU AND SEARCH
------------------------------------------------*/

    $('#top-menu').click(function(){
        $('#top-menu .wrapper').slideToggle();
        $('#top-menu').toggleClass('top-menu-active');
    });

    menu_toggle.click(function(){
        nav_menu.slideToggle();
       $('.main-navigation').toggleClass('menu-open');
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 290) {
            $('.site-header.sticky-header').fadeIn();
            if ($('.site-header').hasClass('sticky-header')) {
                $('.site-header.sticky-header').addClass('nav-shrink');
                $('.site-header.sticky-header').fadeIn();
            }
        } 
        else {
            $('.site-header.sticky-header').removeClass('nav-shrink');
        }
    });

    $('.main-navigation ul li a.search').click(function() {
        $(this).toggleClass('search-open');
        $('.main-navigation #search').toggle();
        $('.main-navigation .search-field').focus();
        $('body').addClass('search-open');
    });

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            $('.main-navigation .search').removeClass('search-open');
            $('.main-navigation #search').hide();
            $('body').removeClass('search-open');
        }
    });

    $(document).click(function (e) {
      var container = $("#masthead");
       if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.main-navigation .search').removeClass('search-open');
            $('.main-navigation #search').hide();
            $('body').removeClass('search-open');
        }
    });

/*------------------------------------------------
                SLICK SLIDERS
------------------------------------------------*/

featured_slider.slick();
regular.slick();


/*------------------------------------------------
            POPUP VIDEO
------------------------------------------------*/

    $(".popup-video").click(function (event) {
        event.preventDefault();
        $('.video-content-wrapper').addClass('active');
        $('.video-content-wrapper .pop-wrapper').fadeIn();
    });

    $(document).click(function (e) {
        var container = $(".popup-video, .pop-wrapper");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".mejs-controls .mejs-playpause-button.mejs-pause button").trigger("click");
            $('.video-content-wrapper').removeClass('active');
            $('.video-content-wrapper .pop-wrapper').fadeOut();
            
        }
    });


/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});
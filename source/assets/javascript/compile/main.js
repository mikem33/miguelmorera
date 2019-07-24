jQuery(document).ready(function($) {
    
    if (is_touch_device()) {
        $('body').removeClass('no-touch');
    }
    
    var stickyOffset = $('.header').offset();
    var contentDivs = $('[data-scroll]');
    $(document).scroll(function() {
        contentDivs.each(function() {
            var thisOffset = $(this).offset();
            var actPosition = thisOffset.top - $(window).scrollTop();
            var currentSectionBgColor = $(this).attr('data-bg-color');
            var currentSectionType = $(this).attr('data-type');
            if (actPosition < stickyOffset.top && actPosition + $(this).height() > 0) {
                if (currentSectionType == 'dark') {
                    if ($('.header').hasClass('header--light')) {
                        $('.header').removeClass('header--light');
                    }
                    $('.toggle-nav__hamburger span').css('background-color', currentSectionBgColor);
                } else {
                    $('.toggle-nav__hamburger span').removeAttr('style');
                    $('.header').addClass('header--light');
                }
                return false;
            }
        });
    });

});

document.addEventListener("DOMContentLoaded", function() {
    let lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
    let active = false;

    const lazyLoad = function() {
        if (active === false) {
            active = true;

            setTimeout(function() {
                lazyImages.forEach(function(lazyImage) {
                    if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
                        lazyImage.src = lazyImage.dataset.src;
                        // lazyImage.srcset = lazyImage.dataset.srcset;
                        lazyImage.classList.remove("lazy");
                        lazyImage.classList.add("lazy--loaded");

                        lazyImages = lazyImages.filter(function(image) {
                            return image !== lazyImage;
                        });

                        if (lazyImages.length === 0) {
                            document.removeEventListener("scroll", lazyLoad);
                            window.removeEventListener("resize", lazyLoad);
                            window.removeEventListener("orientationchange", lazyLoad);
                        }
                    }
                });

                active = false;
            }, 200);
        }
    };

    document.addEventListener( 'scroll', lazyLoad );
    window.addEventListener( 'resize', lazyLoad );
    window.addEventListener( 'orientationchange', lazyLoad );
});

document.addEventListener( 'DOMContentLoaded', function() {
    var lazyBackgrounds = [].slice.call( document.querySelectorAll( '.lazy-background' ) );

    if ( 'IntersectionObserver' in window ) {
        let lazyBackgroundObserver = new IntersectionObserver( function( entries, observer ) {
            entries.forEach( function( entry ) {
                if ( entry.isIntersecting ) {
                    entry.target.style.backgroundImage = 'url("' + entry.target.dataset.src + '")';
                    entry.target.classList.add( 'visible' );
                    lazyBackgroundObserver.unobserve( entry.target );
                }
            });
        });

        lazyBackgrounds.forEach( function( lazyBackground ) {
            lazyBackgroundObserver.observe( lazyBackground );
        });
    }
});

// Get the scrollbar width
const getScrollBarWidth = () => window.innerWidth - document.documentElement.getBoundingClientRect().width;

// Assign the obtained data width to a CSS Variables.
const cssScrollBarWidth = () => document.documentElement.style.setProperty( '--scrollbar', `${getScrollBarWidth()}px` );
let cssScrollBarClass = () => document.documentElement.classList.add( 'scrollbar--calculated' );

// Assign this variable when the page loads.
addEventListener( 'load', cssScrollBarWidth );
addEventListener( 'load', cssScrollBarClass );

// Reassign the variable when the window resizes.
addEventListener('resize', cssScrollBarWidth);
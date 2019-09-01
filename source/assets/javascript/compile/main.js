jQuery(document).ready(function($) {
    
    if (is_touch_device()) {
        $('body').removeClass('no-touch');
    }
    
    var stickyOffset = $('.header').offset();
    var contentDivs = $('[data-scroll]');

    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('html').addClass('document--scrolled');
        } else {
            $('html').removeClass('document--scrolled');
        }
    });

    $(document).scroll(function() {
        contentDivs.each(function() {
            var htmlElem = document.querySelector('html');
            var currentHeaderPadding = getComputedStyle(htmlElem).getPropertyValue('--header-padding');
            currentHeaderPadding = parseInt(currentHeaderPadding.slice(0,2));
            var thisOffset = $(this).offset();
            var actPosition = thisOffset.top - (currentHeaderPadding / 2) - $(window).scrollTop();
            var currentSectionBgColor = $(this).attr('data-bg-color');
            var currentSectionType = $(this).attr('data-type');
            if (actPosition < stickyOffset.top && actPosition + $(this).height() > 0) {
                if (currentSectionType == 'dark') {
                    $('.header').removeClass('header--light');
                } else {
                    $('.header').addClass('header--light');
                }
                $('.toggle-nav__hamburger span').css('background-color', currentSectionBgColor);
                return false;
            }
        });
    });

});

// Select all links with hashes
$('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
    // On-page links
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        // Figure out element to scroll to
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        // Does a scroll target exist?
        if (target.length) {
            // Only prevent default if animation is actually gonna happen
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000, function() {
                // Callback after animation
                // Must change focus!
                var $target = $(target);
                $target.focus();
                if ($target.is(":focus")) { // Checking if the target was focused
                    return false;
                } else {
                    $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                    $target.focus(); // Set focus again
                };
            });
        }
    }
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
const cssScrollBarWidth = () => document.documentElement.style.setProperty('--scrollbar', `${getScrollBarWidth()}px`);
let cssScrollBarClass = () => document.documentElement.classList.add('scrollbar--calculated');

// Assign global variable the current header padding-top style.
function cssHeaderPadding(header) {
    var header = document.querySelector('.header');
    var headerPadding = window.getComputedStyle(header, null).getPropertyValue('padding-left');
    document.documentElement.style.setProperty('--header-padding', headerPadding);
    console.log(headerPadding);
}

// Assign this variable when the page loads.
addEventListener('load', cssScrollBarWidth);
addEventListener('load', cssScrollBarClass);
addEventListener('load', cssHeaderPadding);

// Reassign the variable when the window resizes.
addEventListener('resize', cssScrollBarWidth);
addEventListener('resize', cssHeaderPadding);
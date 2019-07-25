jQuery(document).ready(function($) {
    
    $('.toggle-nav').on('click', function() {
        $('html').toggleClass('scrollbar--blocked menu--opened');
        $('.nav').toggleClass('nav--opened');
        $(this).toggleClass('active');
        // Keep the current menu toggle bars color.
        if ($('.toggle-nav__hamburger span')[0].style['background-color']) {
            var currentBgBarColor = $('.toggle-nav__hamburger span')[0].style['background-color'];
            $('.toggle-nav__hamburger span').attr('data-bar-color', currentBgBarColor);
            $('.toggle-nav__hamburger span').removeAttr('style');
        } else if ($('.toggle-nav__hamburger span').attr('data-bar-color')) {
            var currentBgBarColor = $('.toggle-nav__hamburger span').attr('data-bar-color');
            $('.toggle-nav__hamburger span').removeAttr('data-bar-color');
            $('.toggle-nav__hamburger span').css('background-color', currentBgBarColor);
        }
        // Change button text
        var altText = $(this).data('alt-text');
        var currentText = $('.toggle-nav .text').html();
        $('.toggle-nav .text').html(altText);
    });

});
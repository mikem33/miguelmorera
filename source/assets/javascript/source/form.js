jQuery(document).ready(function($) {
    // Delete placeholder of the search form on focus.
    $('input[type=text], input[type=email], input[type=tel], input[type=url], textarea').focus(function(){
        $(this).data('placeholder',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
        $(this).closest('fieldset').addClass('active');
    });

    // Turn on the placeholder when the field lose focus and there is no added content.
    $('input[type=text], input[type=email], input[type=tel], input[type=url], textarea').blur(function(){
        if (!$(this).val()) {
            $(this).closest('fieldset').removeClass('active');
            $(this).attr('placeholder',$(this).data('placeholder'));
        }
    });
});
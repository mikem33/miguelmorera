<?php
    
    // Include the ACF plugin.
    include_once( MY_ACF_PATH . 'acf.php' );

    // Customize the url setting to fix incorrect asset URLs.
    add_filter('acf/settings/url', 'my_acf_settings_url');
    function my_acf_settings_url( $url ) {
        return MY_ACF_URL;
    }

    if ( defined( 'WP_ENV_PRODUCTION' ) ) {
        // (Optional) Hide the ACF admin menu item.
        add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
        function my_acf_settings_show_admin( $show_admin ) {
            return false;
        }
    }

    add_filter('acf/settings/save_json', 'my_acf_json_save_point'); 
    function my_acf_json_save_point( $path ) {
        $path = ROOT_PATH . '/source/includes/acf-json';
        return $path;
    }

    add_filter('acf/settings/load_json', 'my_acf_json_load_point');
    function my_acf_json_load_point( $paths ) {
        unset($paths[0]);
        $paths[] = get_stylesheet_directory() . '/includes/acf-json';
        return $paths;
    }

    // ACF Options Page.
    if(function_exists('acf_add_options_page')) { 
         acf_add_options_page(array(
            'page_title'    => 'Theme Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme_settings',
            'capability'    => 'edit_posts',
            'redirect'      => false, 
        ));
    }
    
    // add_filter('acf/settings/show_admin', '__return_false');

    // Disable auto-generated p on ACF WYSIWIG editor
    function ptobr($string) {
        return preg_replace("/<\/p>[^<]*<p>/", "<br /><br />", $string);
    }

    function stripp($string) {
        return preg_replace('/(<p>|<\/p>)/i','',$string) ;
    }
?>
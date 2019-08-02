<!DOCTYPE html>
<?php
    if (is_home()) {
        $page_id = get_option('page_for_posts', true); 
    } else {
        $page_id = get_the_ID();
    }
    $page_bg_color = get_field('main_page_color', $page_id);
    $page_header_type = get_field('main_header_type', $page_id);
?>
<html <?php echo get_language_attributes(); ?> style="--main-page-color: <?php echo $page_bg_color; ?>;" data-main-color="<?php echo $page_bg_color; ?>">
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>">
        <?php if ( is_front_page() ) : ?>
            <title><?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?></title>
            <meta name="description" content="<?php bloginfo( 'description' ); ?>">
        <?php elseif ( is_single() ) : ?>
            <title><?php wp_title('-',true,'right'); ?><?php bloginfo('name'); ?></title>
            <meta name="description" content="<?php meta_description(); ?>">
        <?php else : ?>
            <title><?php wp_title('-',true,'right'); ?><?php bloginfo('name'); ?></title>
            <meta name="description" content="<?php bloginfo( 'description' ); ?>">
        <?php endif; ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            
        <link rel="alternate" type="text/xml" title="<?php bloginfo( 'name' ); ?> RSS 0.92 Feed" href="<?php bloginfo( 'rss_url' ); ?>">
        <link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?> Atom Feed" href="<?php bloginfo( 'atom_url' ); ?>">
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS 2.0 Feed" href="<?php bloginfo( 'rss2_url' ); ?>">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <header class="header flex" data-header-type="<?php echo $page_header_type; ?>">
            <a href="<?php echo home_url(); ?>" class="logo">
                <svg><use xlink:href="#logo" /></svg>
            </a>
            <button class="toggle-nav" data-alt-text="<?php _e('Close','miguelmorera'); ?>">
                <span class="text"><?php _e('Menu','miguelmorera'); ?></span>
                <span class="toggle-nav__hamburger">
                    <span></span>
                </span>
            </button>
        </header> <!--  /.header -->
        <main class="main" role="main">
            <div class="nav section space" role="menu">
                <?php $menuParameters = array(
                    'menu'            => 'header-menu',
                    'container'       => 'nav',
                    'container_class' => 'nav__items',
                    'echo'            => false,
                    'items_wrap'      => '%3$s',
                    'depth'           => 0,
                ); ?>
                <?php echo strip_tags(wp_nav_menu( $menuParameters ), '<nav>,<a>' ); ?>
                <p class="nav__colophon">&copy; 2010 - <?php echo date('Y'); ?> Miguel Morera</p>
            </div> <!--  /.nav -->
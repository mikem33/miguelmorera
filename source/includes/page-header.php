<?php

    if (is_home()) {
        $page_id = get_option('page_for_posts', true);
    } else {
        $page_id = $post->ID;
    }
    $page_bg_color = get_field('main_page_color', $page_id);
    $page_header_type = get_field('main_header_type', $page_id);
    $page_header_stuff =  get_field('page_header_stuff', $page_id);
?>
<header class="page__header <?php echo $additional_header_classes; ?>" data-bg-color="<?php echo $page_bg_color; ?>" data-type="<?php echo $page_header_type; ?>" data-scroll>
    <div class="content">
        <?php if (is_front_page()) : ?>
            <span class="alpha-warning"><?php _e('Alpha', 'miguelmorera'); ?></span>
        <?php endif; ?>
        <?php if (is_archive()) : ?>
            <?php if (have_posts()) : ?>
                <?php 
                    $post = $posts[0]; // hack: set $post so that the_date() works
                    if (is_category()) : 
                ?>
                    <h1 class="title alpha"><?php _e('Archive Category of','miguelmorera'); ?> &ldquo;<?php single_cat_title(); ?>&rdquo;</h1>
                <?php elseif (is_tag()) : ?>
                    <h1 class="title alpha"><?php _e('Posts tagged with','miguelmorera'); ?> &ldquo;<?php single_tag_title(); ?>&rdquo;</h1>
                <?php elseif (is_day()) : ?>
                    <h1 class="title alpha"><?php _e('Archive with date','miguelmorera'); ?> <?php the_time('F jS, Y'); ?></h1>
                <?php elseif (is_month()) : ?>
                    <h1 class="title alpha"><?php _e('Archivo of','miguelmorera'); ?> <?php the_time('F, Y'); ?></h1>
                <?php elseif (is_year()) : ?>
                    <h1 class="title alpha"><?php _e('Archive from year','miguelmorera'); ?> <?php the_time('Y'); ?></h1>
                <?php elseif (is_author()) : ?>
                    <h1 class="title alpha"><?php _e('Author Archive','miguelmorera'); ?></h1>
                <?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
                    <h1 class="title alpha"><?php _e('Blog Archive','miguelmorera'); ?></h1>
                <?php endif; ?>
            <?php else : ?>
                <h1 class="title alpha"><?php _e('There are no results.','miguelmorera'); ?></h1> <!--  /.title alpha -->
            <?php endif; ?>
        <?php elseif (is_404()) : ?>
            <h1 class="title alpha"><?php _e('Page not found','miguelmorera'); ?></h1> <!--  /.title alpha -->
        <?php
            elseif ($page_header_stuff['page_header_title']) :
        ?>
            <h1 class="title alpha"><?php echo $page_header_stuff['page_header_title']; ?></h1> <!--  /.title alpha -->
        <?php else : ?>
            <h1 class="title alpha"><?php echo get_the_title($page_id); ?></h1> <!--  /.title alpha -->
        <?php endif; ?>
        <?php echo $page_header_stuff['page_header_text']; ?>
        <?php if (is_front_page()) : ?>
            <a href="<?php echo get_permalink(26); ?>" class="button button--white-purple button--filled button--icon">
                <span><?php _e('See my works', 'miguelmorera'); ?></span>
                <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
            </a>
        <?php endif; ?>
    </div> <!--  /.content -->
    <?php if ($page_header_style == 'hero') : ?>
        <a href="#content" class="content-anchor">
            <svg width="20" height="20" class="ico"><use xlink:href="#ico-circle-chevron" /></svg>
        </a>
        <?php if (is_front_page()) : ?>
            <canvas class="header-circles"></canvas> <!--  /.header-circles -->
        <?php endif; ?>
    <?php endif; ?>
</header>
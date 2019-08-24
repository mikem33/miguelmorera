<?php
    /**
     * Function for register a sidebar.
     */
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => __('Sidebar Widgets','prometheus'),
            'id'   => 'sidebar-widgets',
            'description'   => __( 'These are widgets for the sidebar.','prometheus'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
    }

    /**
     * Function for enable thumbnails generation and custom sizes.
     */
    add_theme_support('post-thumbnails');
    add_image_size('item-thumbnail', 960, 600, true);
    add_image_size('item-thumbnail-medium', 640, 400, true);
    add_image_size('item-thumbnail-little', 480, 300, true);

    /**
     * Function to get responsive images on post thumbnails with custom created sizes.
     * @param  integer  $post_id    Post ID to get thumbnail.
     * @param  string   $size       Name of the thumbnail to get.
     * @param  string   $class      Add class to the image.
     * @param  string   $echo       It is for echo or returned the image value.
     * @return string
     */
    function mm_post_thumbnail($post_id, $size = 'item-thumbnail', $class = '', $echo = true) {
        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size )[0];
        $thumbnail_medium = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size . '-medium' )[0];
        $thumbnail_little = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size . '-little' )[0];

        $image  = '<img src="' . $thumbnail . '"';
        $image .= ( $thumbnail_medium && $thumbnail_little ?  ' srcset="' : '' ); // open srcset
        $image .= ( $thumbnail_little ? $thumbnail_little . ' 480w' : '' );
        $image .= ( $thumbnail_medium && $thumbnail_little ? ', ' : '' );
        $image .= ( $thumbnail_medium ? $thumbnail_medium . ' 640w' : '' );
        $image .= ( $thumbnail_medium && $thumbnail_little ? ', ' : '' );
        $image .= ( $thumbnail ? $thumbnail . ' 960w' : '' );
        $image .= ( $thumbnail_medium && $thumbnail_little ?  '"' : '' ); // close srcset
        $image .= ( $class ? ' class="' . esc_attr($class) . '"' : '' );
        $image .= ' sizes="auto" alt="' . get_the_title($post_id) . '">';
        if ($echo == true) {
            echo $image;
        } else {
            return $image;
        }
    }

    /**
     * Function to enable wide images support on Gutenberg.
     */
    function wide_images_setup() {
        add_theme_support( 'align-wide' );
    }
    add_action( 'after_setup_theme', 'wide_images_setup' );

    /**
     * Create default menu spaces.
     */
    function register_my_menus() {
        register_nav_menus(
            array(
              'header-menu' => __('Header Menu', 'prometheus'),
              'footer-menu' => __('Footer Menu', 'prometheus')
            )
        );
    }
    add_action( 'init', 'register_my_menus' );

    /**
     * Determine the text of the 'Read more'
     * @param  string   $more_link          The original link of the full post.
     * @param  string   $more_link_text     The original text of the link to the full post.
     * @return string
     */
    function my_more_link($more_link, $more_link_text) {
        return str_replace($more_link_text, __('Read more &raquo;', 'prometheus'), $more_link);
    }
    add_filter('the_content_more_link', 'my_more_link', 10, 2);

    /**
     * Meta description text for the head tag.
     */
    function meta_description() {
        $current_post = get_post();
        $post_content = shortenParagraph($current_post->post_content, 300);
        echo strip_tags($post_content);
    }

    /**
     * Shorten paragraph function.
     * @param  string   $paragraph  The original text
     * @param  integer  $characters The number of characters to show
     * @return string               The result string.
     */
    function shortenParagraph($paragraph, $characters) {
        if (strlen($paragraph) <= $characters) {
            return $paragraph;
        } else {
            $newParagraph = mb_substr($paragraph, 0, $characters).'...';
            return $newParagraph;
        }
    }

    /**
     * Add custom classes to the previous and next pagination links.
     */
    function next_posts_link_attributes() { return 'class="button button--next"'; }
    function previous_posts_link_attributes() { return 'class="button button--previous"'; }
    add_filter('next_posts_link_attributes', 'next_posts_link_attributes');
    add_filter('previous_posts_link_attributes', 'previous_posts_link_attributes');

    /**
     * Custom Navigation
     * Based on Bill Erirckson custom pagination.
     * @author Bill Erickson
     * @see https://www.billerickson.net/custom-pagination-links/
     *
     */
    function mm_navigation() {
        $post_type = get_post_type();
        $nav_classes = 'nav--pagination';
        switch ($post_type) {
            case 'post':
                $nav_classes = $nav_classes.' pagination--white-red';
                break;
            default:
                $nav_classes = $nav_classes.' pagination--dark-grey';
                break;
        }
        $settings = array(
            'count' => 6,
            'prev_text' => '<svg width="10" height="17" class="ico"><use xlink:href="#ico-chevron" /></svg>',
            'next_text' => '<svg width="10" height="17" class="ico"><use xlink:href="#ico-chevron" /></svg>'
        );
        global $wp_query;
        $current = max( 1, get_query_var( 'paged' ) );
        $total = $wp_query->max_num_pages;
        $links = array();
        // Offset for next link
        if( $current < $total ) { $settings['count']--; }
        // Previous
        if( $current > 1 ) {
            $settings['count']--;
            $links[] = mm_navigation_link( $current - 1, ' nav__link--prev '.$nav_button_color_class, $settings['prev_text'] );
        }
        // Current
        $links[] = mm_navigation_link( $current, 'current' );
        // Next Pages
        for( $i = 1; $i < $settings['count']; $i++ ) {
            $page = $current + $i;
            if( $page <= $total ) {
                $links[] = mm_navigation_link( $page );
            }
        }
        // Next
        if( $current < $total ) {
            $links[] = mm_navigation_link( $current + 1, ' nav__link--next'.$nav_button_color_class, $settings['next_text'] );
        }
        echo '<nav class="'.$nav_classes.'" role="navigation">';
            echo join( '', $links );
        echo '</nav>';
    }

    /**
     * Navigation Link
     * Based on Bill Erickson pagination.
     * @author Bill Erickson
     * @see https://www.billerickson.net/custom-pagination-links/
     *
     * @param int $page
     * @param string $class
     * @param string $label
     * @return string $link
     */
    function mm_navigation_link( $page = false, $class = '', $label = '' ) {
        if( !$page ) { return; }
        $classes = array( 'nav__link' );
        if( !empty( $class ) ) { 
            $classes[] = $class;
        }
        $classes = array_map( 'esc_attr', $classes );
        $label = $label ? $label : $page;
        $link = esc_url_raw( get_pagenum_link( $page ) );
        return '<a class="' . join ( ' ', $classes ) . '" href="' . $link . '">' . $label . '</a>';
    }

    /**
     * Adds a responsive embed wrapper around oEmbed content
     * Filters the oEmbed process to run the responsive_embed() function
     * @param  string $html The oEmbed markup
     * @param  string $url  The URL being embedded
     * @param  array  $attr An array of attributes
     * @return string       Updated embed markup
     */
    function responsive_embed($html, $url, $attr) {
        return $html!=='' ? '<div class="embed-container">'.$html.'</div>' : '';
    }
    add_filter('embed_oembed_html', 'responsive_embed', 10, 3);

    /**
     * Loads Google Fonts asynchronously
     * @return string  Script tag with the necessary javascript.
     */
    function load_google_fonts() { ?>
        <?php $fonts = "'Rubik:400,400i,500,500i&display=swap'"; ?>
        <?php if ($fonts) : ?>
            <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
            <script>
                WebFont.load({
                    google: {
                        families: [<?php echo $fonts; ?>]
                    }
                });
            </script>
        <?php endif; ?>
    <?php }
    
    add_action('wp_footer', 'load_google_fonts');

    /**
     * Add reading time for posts.
     */
    function reading_time() {
        $content = get_post_field( 'post_content', $post->ID );
        $word_count = str_word_count( strip_tags( $content ) );
        $readingtime = ceil($word_count / 200);

        $totalreadingtime = $readingtime . ' min. read';

        return $totalreadingtime;
    }

    /**
     * Change the order of the textarea field in comment forms.
     */
    function mm_move_comment_field_to_bottom( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
        return $fields;
    }
     
    add_filter( 'comment_form_fields', 'mm_move_comment_field_to_bottom' );

    function mm_comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        $output = '<article class="'.implode(' ', get_comment_class()).'" id="comment-'.get_comment_ID().'">';
        $output .= '<header class="comment__header">';
        $output .= '<div class="avatar">';
        $avatar_size = 64;
        if ('0' != $comment->comment_parent) {
            $avatar_size = 44;
        }
        $output .= get_avatar($comment, $avatar_size);
        $output .= '</div><!-- /.avatar -->';
        $output .= '<div class="comment__meta">';
        $output .= '<h4 class="title beta">'.get_comment_author_link().'</h4>';
        $comment_timestamp = sprintf( __( '%1$s at %2$s', 'prometheus' ), get_comment_date( '', $comment ), get_comment_time() );
        $output .= '<a href="'.esc_url( get_comment_link( $comment, $args ) ).'">';
        $output .= '<time datetime="'.get_comment_time('c').'" title="'.$comment_timestamp.'">';
        $output .= $comment_timestamp;
        $output .= '</time>';
        $output .= '</a>';
        $output .= '</div><!-- /.comment__meta -->';
        $output .= '</header><!-- /.comment__header -->';
        add_filter('get_comment_text','wpautop');
        $output .= '<div class="comment__content">';
        $output .= get_comment_text();
        $output .= '</div><!-- /.comment__content -->';
        remove_filter('get_comment_text','wpautop');
        if ($comment->comment_approved == '0') {
            $output .= '<p class="moderation">'.__('Your comment is awaiting moderation.','prometheus').'</p>';
        }
        $output .= '<div class="comment__reply">';
        $output .= get_comment_reply_link(
                        array_merge( $args, 
                            array(
                                'depth' => $depth, 
                                'max_depth' => $args['max_depth']
                            )
                        )
                    );
        $output .= '</div>';
        $output .= '</article>';

        echo $output;
    }

    function mm_custom_class_comment_reply_link($content) {
        $extra_classes = 'button button--dark-grey button--filled';
        return preg_replace( '/comment-reply-link/', 'comment-reply-link ' . $extra_classes, $content);
    }

    add_filter('comment_reply_link', 'mm_custom_class_comment_reply_link', 99);

    /**
     * Get Page ID by Slug.
     */
    function get_page_id_by_slug($page_slug) {
        $page = get_page_by_path($page_slug);
        if ($page) {
            return $page->ID;
        } else {
            return null;
        }
    }

    global $detect;
    $detect = new Mobile_Detect;

    add_filter( 'wpcf7_load_js', '__return_false' );
    add_filter( 'wpcf7_load_css', '__return_false' );

?>
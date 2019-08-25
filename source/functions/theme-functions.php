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
    function pr_post_thumbnail($post_id, $size = 'item-thumbnail', $class = '', $echo = true) {
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
     * Adds a responsive embed wrapper around oEmbed content
     * Filters the oEmbed process to run the responsive_embed() function
     */
    if(!function_exists('video_content_filter')) {
        function video_content_filter($content) {

            // Search for an iframe.
            $pattern = '/<iframe.*?src=".*?(vimeo|youtu\.?be).*?".*?<\/iframe>/';
            preg_match_all($pattern, $content, $matches);

            foreach ($matches[0] as $match) {
                $wrappedframe = '<div class="responsive-video"><div class="content">' . $match . '</div></div>';
                $content = str_replace($match, $wrappedframe, $content);
            }
            return $content;
        }
        // Filter posts 'the_content'.
        add_filter( 'the_content', 'video_content_filter' );

    }

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
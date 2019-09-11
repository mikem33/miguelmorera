<?php
    $post_type = get_post_type();
    switch ($post_type) {
        case 'mm_work':
            $slug = get_current_blog_id() == 1 ? 'works':'trabajos';
            $page_id = get_page_id_by_slug($slug);
            break;
        case 'mm_comic':
            $page_id = get_page_id_by_slug('comics');
            break;
        case 'mm_dev_post':
            $slug = get_current_blog_id() == 1 ? 'development-blog':'blog-desarrollo';
            $page_id = get_page_id_by_slug($slug);
            break;
        case 'mm_diary':
            $slug = get_current_blog_id() == 1 ? 'diary':'diario';
            $page_id = get_page_id_by_slug($slug);
            break;
        default:
            if (is_home()) {
                $page_id = get_option('page_for_posts', true); 
            } else {
                $page_id = get_the_ID();
            }
            break;
    }

    $page_bg_color = get_field('main_page_color', $page_id);
    $page_header_type = get_field('main_header_type', $page_id);
?>
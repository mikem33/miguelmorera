<?php
    $post_type = get_post_type();
    switch ($post_type) {
        case 'mm_work':
            $slug = 'trabajos';
            $page_parent_id = get_page_id_by_slug($slug);
            break;
        case 'mm_comic':
            $page_parent_id = get_page_id_by_slug('comics');
            break;
        case 'mm_dev_post':
            $slug = 'blog-desarrollo';
            $page_parent_id = get_page_id_by_slug($slug);
            break;
        case 'mm_diary':
            $slug = 'diario';
            $page_parent_id = get_page_id_by_slug($slug);
            break;
        default:
            if (is_home()) {
                $page_id = get_option('page_for_posts', true); 
            } else {
                $page_id = get_the_ID();
            }
            break;
    }

    if (($post_type != 'post' || $post_type != 'page') && !is_home()) {
        $page_id = $page_parent_id;
    }
    
    $page_bg_color = get_field('main_page_color', $page_id);
    $page_header_type = get_field('main_header_type', $page_id);

    if ($post_type != 'post' || $post_type != 'page') {
        if (is_home()) {
            $page_id = get_option('page_for_posts', true); 
        } else {
            $page_id = get_the_ID();
        }
    }
?>
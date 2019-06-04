<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
    <input type="text" id="s" name="s" placeholder="<?php _e('Buscar','miguelmorera'); ?>" value="<?php the_search_query(); ?>">
    <input type="submit" value="">
</form>
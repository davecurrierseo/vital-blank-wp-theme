<form method="get" id="searchform" class="searchform" action="<?php bloginfo('siteurl'); ?>" role="search">
	<label for="s" class="screen-reader-text"><?php _ex( 'Search', 'assistive text', '_s' ); ?></label>
	<input type="search" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', '_s' ); ?>" />
	<input type="submit" class="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button', '_s' ); ?>" />
</form>
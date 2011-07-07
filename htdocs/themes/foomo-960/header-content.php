		<? $heading_tag = (is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
		<<?= $heading_tag; ?> id="site-title">
			<span><a href="<?= home_url('/'); ?>" title="<?= esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><? bloginfo('name'); ?></a></span>
		</<?= $heading_tag; ?>>

		<div id="site-description"><? bloginfo('description'); ?></div>

		<? if (is_singular() && current_theme_supports('post-thumbnails') && has_post_thumbnail($post->ID) && ($image = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ))): ?>
			<div id="site-teaser"><?= get_the_post_thumbnail($post->ID); ?></div>
		<? elseif (get_header_image()) : ?>
			<div id="site-teaser"><img src="<? header_image(); ?>" alt="" /></div>
		<? endif; ?>

		<div id="site-menu">
			<? wp_nav_menu(array('container_class' => 'menu-header', 'theme_location' => 'primary')); ?>
		</div>


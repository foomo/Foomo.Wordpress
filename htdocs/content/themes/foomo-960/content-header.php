	<? if (\Foomo\Wordpress\Themes\Foomo960::$debug) echo '<!-- content-header -->' ?>
	<div id="header">
		<? $heading_tag = (is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
		<<?= $heading_tag; ?> id="site-title">
			<a href="<?= home_url('/'); ?>" title="<?= esc_attr(get_bloginfo('name', 'display')); ?>"><? bloginfo('name'); ?></a>
		</<?= $heading_tag; ?>>

		<? wp_nav_menu(array('container' => '', 'theme_location' => 'main')); ?>
	</div>
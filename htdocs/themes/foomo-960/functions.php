<?php


function foomo_get_title()
{
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && (is_home() || is_front_page())) echo " | $site_description";

	// Add a page number if necessary:
	if ($paged >= 2 || $page >= 2) echo ' | ' . sprintf( __('Page %s', 'foomo-360'), max($paged, $page));
}


function foomo_get_active_sidebar_count(array $names, $append='', $prepend='')
{
	$count = 0;
	foreach ($names as $name) if (is_active_sidebar($prepend . $name . $append)) $count++;
	return $count;
}

function foomo_get_widget_count($id)
{
	$mysidebars = wp_get_sidebars_widgets();
	return count($mysidebars[$id]);
}

function foomo_get_container_classes()
{
	$before = is_active_sidebar('before-content-aside');
	$after = is_active_sidebar('after-content-aside');

	if ($before && $after) {
		return ' class="container-sidebars-2"';
	} else if ($before || $after) {
		return ' class="container-sidebars-1"';
	} else {
		return '';
	}
}
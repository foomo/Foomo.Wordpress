<?php

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
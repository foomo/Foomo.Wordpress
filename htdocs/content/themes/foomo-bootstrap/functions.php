<?php

#$theme = new \Foomo\Wordpress\Themes\FoomoBootstrap('foomo-bootstrap', 'Foomo Twitter Bootstrap');

/**
 * Display search form.
 *
 * Will first attempt to locate the searchform.php file in either the child or
 * the parent, then load it. If it doesn't exist, then the default search form
 * will be displayed. The default search form is HTML, which will be displayed.
 * There is a filter applied to the search form HTML in order to edit or replace
 * it. The filter is 'get_search_form'.
 *
 * This function is primarily used by themes which want to hardcode the search
 * form into the sidebar and also by the search widget in WordPress.
 *
 * There is also an action that is called whenever the function is run called,
 * 'get_search_form'. This can be useful for outputting JavaScript that the
 * search relies on or various formatting that applies to the beginning of the
 * search. To give a few examples of what it can be used for.
 *
 * @since 2.7.0
 * @param boolean $echo Default to echo and not return the form.
 */
function foomo_bootstrap_get_search_form($name, $echo = true) {
	do_action('foomo_bootstrap_get_search_form');

	$templates = array();
	if (isset($name)) $templates[] = "searchform-{$name}.php";
	$templates[] = 'searchform.php';

	$search_form_template = locate_template($templates, false, false);
	if ('' != $search_form_template ) {
		require($search_form_template);
		return;
	}

	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</div>
	</form>';

	if ($echo) {
		echo apply_filters('get_search_form', $form);
	} else {
		return apply_filters('get_search_form', $form);
	}
}
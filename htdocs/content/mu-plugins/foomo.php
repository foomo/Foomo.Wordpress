<?
/*
Plugin Name: foomo
Description: foomo integration plugin
Author: franklin <franklin@weareinteractive.com>
Author URI: http://www.weareinteractive.com/
Plugin URI: http://www.foomo.org/
Version: 0.1
@todo add screenshot
*/

\Foomo\Wordpress::init(__FILE__);
#\Foomo\Wordpress\Admin::init();
#\Foomo\Wordpress\Plugins::init();
#\Foomo\Wordpress\Widgets::init();
#\Foomo\Wordpress\Frontend::init();
#\Foomo\Wordpress\Shortcodes::init();


/*
 * Examples:
 *
 * html( 'p', 'Hello world!' );												<p>Hello world!</p>
 * html( 'a', array( 'href' => 'http://example.com' ), 'A link' );			<a href="http://example.com">A link</a>
 * html( 'img', array( 'src' => 'http://example.com/f.jpg' ) );				<img src="http://example.com/f.jpg" />
 * html( 'ul', html( 'li', 'a' ), html( 'li', 'b' ) );						<ul><li>a</li><li>b</li></ul>
 */
if ( ! function_exists( 'html' ) ):
function html( $tag ) {
	$args = func_get_args();

	$tag = array_shift( $args );

	if ( is_array( $args[0] ) ) {
		$closing = $tag;
		$attributes = array_shift( $args );
		foreach ( $attributes as $key => $value ) {
			if ( false === $value )
				continue;

			if ( true === $value )
				$value = $key;

			$tag .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}
	} else {
		list( $closing ) = explode( ' ', $tag, 2 );
	}

	if ( in_array( $closing, array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta' ) ) ) {
		return "<{$tag} />";
	}

	$content = implode( '', $args );

	return "<{$tag}>{$content}</{$closing}>";
}
endif;

// Generate an <a> tag
if ( ! function_exists( 'html_link' ) ):
function html_link( $url, $title = '' ) {
	if ( empty( $title ) )
		$title = $url;

	return html( 'a', array( 'href' => $url ), $title );
}
endif;


//_____Compatibility layer_____

// WP < ?
if ( ! function_exists( 'set_post_field' ) ) :
function set_post_field( $field, $value, $post_id ) {
	global $wpdb;

	$post_id = absint( $post_id );
	$value = sanitize_post_field( $field, $value, $post_id, 'db' );

	return $wpdb->update( $wpdb->posts, array( $field => $value ), array( 'ID' => $post_id ) );
}
endif;
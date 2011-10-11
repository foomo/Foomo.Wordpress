<?php

namespace Foomo\Wordpress;

/**
 * A wrapper for scbForms, containing the formdata
 */
class Form {
	protected $data = array();
	protected $prefix = array();

	function __construct( $data, $prefix = false ) {
		if ( is_array( $data ) )
			$this->data = $data;

		if ( $prefix )
			$this->prefix = (array) $prefix;
	}

	function traverse_to( $path ) {
		$data = \Foomo\Wordpress\Forms::get_value( $path, $this->data );

		$prefix = array_merge( $this->prefix, (array) $path );

		return new \Foomo\Wordpress\Form( $data, $prefix );
	}

	function input( $args ) {
		$value = \Foomo\Wordpress\Forms::get_value( $args['name'], $this->data );

		if ( !is_null( $value ) ) {
			switch ( $args['type'] ) {
			case 'select':
			case 'radio':
				$args['selected'] = $value;
				break;
			case 'checkbox':
				if ( is_array( $value ) )
					$args['checked'] = $value;
				else
					$args['checked'] = ( $value || ( isset( $args['value'] ) && $value == $args['value'] ) );
				break;
			default:
				$args['value'] = $value;
			}
		}

		if ( !empty( $this->prefix ) ) {
			$args['name'] = array_merge( $this->prefix, (array) $args['name'] );
		}

		return \Foomo\Wordpress\Forms::input( $args );
	}
}
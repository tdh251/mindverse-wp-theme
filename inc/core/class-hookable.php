<?php
/**
 * The core Hookable class.
 *
 * This file defines the base class for all other classes in the theme that need to
 * interact with the WordPress hook system (actions and filters).
 *
 * @package    Mindverse
 * @subpackage Inc\Core
 * @author     Case Theme
 */

// Prevents direct access to the file.
namespace Mindverse\Inc\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract class Hookable.
 *
 * Provides convenient wrapper methods for add_action and add_filter,
 * ensuring the correct class context is passed. This class is intended to be
 * extended by other classes, not instantiated directly.
 *
 * @since 1.0.0
 */
abstract class Hookable {
	public function add_action( $hook, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		add_action( $hook, array( $this, $function_to_add ), $priority, $accepted_args );
	}

	public function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		add_filter( $tag, array( $this, $function_to_add ), $priority, $accepted_args );
	}
}
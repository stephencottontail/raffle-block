<?php
/**
 * Plugin Name: Raffle Block
 * Plugin Author: Stephen Dickinson <stephencottontail@me.com>
 * Description: A block for randomly selecting something
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function() {
	$assets = require( 'dist/index.asset.php' );

	wp_enqueue_script( 'sc-raffle-block-editor', plugins_url( 'dist/index.js', __FILE__ ), $assets['dependencies'], $assets['version'], true );
} );

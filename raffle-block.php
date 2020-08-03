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

class SC_Raffle extends WP_Block_Type {
	public $name = 'sc/raffle-block';
	public $editor_script = 'sc-raffle-editor-script';
	public $editor_style = 'sc-raffle-editor-style';
	public $style = 'sc-raffle-style';

	public function __construct() {
		parent::__construct( $this->name, array(
			'editor_script'   => $this->editor_script,
			'editor_style'    => $this->editor_style,
			'render_callback' => array( $this, 'sc_raffle_render' )
		) );
	}

	public function sc_raffle_render() {
		return '<p>Raffle Block &mdash; Front</p>';
	}
}

add_action( 'init', function() {
	$assets = require( 'dist/index.asset.php' );
	wp_register_script( 'sc-raffle-editor-script', plugins_url( 'dist/index.js', __FILE__ ), $assets['dependencies'], $assets['version'], true );

	$raffle = new SC_Raffle();
	register_block_type( $raffle );
} );

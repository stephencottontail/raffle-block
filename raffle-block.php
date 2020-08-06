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
	/**
	 * nb: `$attributes` doesn't get filled until you call
	 * `setAttributes()` in JS, even if you define a default
	 * setting when you register the block. for dynamic blocks,
	 * you can work around this by setting `default` here. in
	 * theory, you could have separate defaults for the editor
	 * and the front-end.
	 */ 
	public $attributes = array(
		'title' => array(
			'type' => 'string',
			'default' => 'Wheel of Decisions'
		)
	);

	public function __construct() {
		parent::__construct( $this->name, array(
			'editor_script'   => $this->editor_script,
			'editor_style'    => $this->editor_style,
			'style'           => $this->style,
			'render_callback' => array( $this, 'sc_raffle_render' )
		) );
	}

	public function sc_raffle_render( $attributes ) {
		/**
		 * nb: because we set a default up there, we can
		 * guarantee that `$attributes` is populated with
		 * something and so we can forgo any checks
		 */
		$title = $attributes['title'];

		$output = '<div class="wp-block-sc-raffle-block">';
		$output .= sprintf( '<h2 class="wp-block-sc-raffle-block__title">%s</h3>', $title );
		$output .= '<div class="wp-block-sc-raffle-block__new-item"><input type="text" class="wp-block-sc-raffle-block__input" placeholder="Add new item&mldr;" /><button class="wp-block-sc-raffle-block__button wp-block-sc-raffle-block__add-new"><span class="wp-block-sc-raffle-block__button-text">Add New Item</span></button></div>';
		$output .= '<div class="wp-block-sc-raffle-block__holder"></div>';
		$output .= '<button class="wp-block-sc-raffle-block__button wp-block-sc-raffle-block__spin"><span class="wp-block-sc-raffle-block__button-text">Spin!</span></button>';
		$output .= '</div><!-- .wp-block-sc-raffle-block -->';

		return $output;
	}
}

add_action( 'init', function() {
	$assets = require( 'dist/index.asset.php' );
	wp_register_script( 'sc-raffle-editor-script', plugins_url( 'dist/index.js', __FILE__ ), $assets['dependencies'], $assets['version'], true );
	wp_register_style( 'sc-raffle-style', plugins_url( 'dist/style.css', __FILE__ ) );

	$raffle = new SC_Raffle();
	register_block_type( $raffle );

	wp_enqueue_style( 'sc-fonts', 'https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap' );
} );

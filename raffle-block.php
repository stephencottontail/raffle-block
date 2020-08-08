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
		$output .= '<div class="wp-block-sc-raffle-block__holder"><div class="wp-block-sc-raffle-block__item wp-block-sc-raffle-block__item-disabled wp-block-sc-raffle-block__item-default">Use the form to add items...<button class="wp-block-sc-raffle-block__button wp-block-sc-raffle-block__remove-item"><span class="wp-block-sc-raffle-block__button-text">Remove Item</span></button></div></div>';
		$output .= '<button class="wp-block-sc-raffle-block__button wp-block-sc-raffle-block__spin"><span class="wp-block-sc-raffle-block__button-text">Spin!</span></button>';
		$output .= '</div><!-- .wp-block-sc-raffle-block -->';

		return $output;
	}
}

add_action( 'init', function() {
	$assets = require( 'dist/index.asset.php' );

	wp_register_script( 'sc-raffle-editor-script', plugins_url( 'dist/index.js', __FILE__ ), $assets['dependencies'], $assets['version'], true );
	if ( empty( get_option( 'raffle_block_options' ) ) ) {
		wp_register_style( 'sc-raffle-style', plugins_url( 'dist/style.css', __FILE__ ) );
		wp_enqueue_style( 'sc-fonts', 'https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap' );
	}

	$raffle = new SC_Raffle();
	register_block_type( $raffle );

} );

add_action( 'admin_menu', function() {
	add_options_page( 'Raffle Block', 'Raffle Block', 'manage_options', 'raffle-block', 'raffle_block_callback' );
} );

add_action( 'admin_init', function() {
	if ( false == get_option( 'raffle_block_options' ) ) {
		add_option( 'raffle_block_options' );
	}

	register_setting( 'cottontail', 'raffle_block_options' );
	add_settings_section( 'developer_mode', 'Developer Mode', 'raffle_block_developer_mode_instructions', 'raffle-block' );
	add_settings_field( 'activate_developer_mode', 'Activate Developer Mode?', 'raffle_block_developer_mode_fields', 'raffle-block', 'developer_mode', array( 'label_for' => 'for_developer_mode' ) );
} );

function raffle_block_callback() {
	ob_start();
	settings_fields( 'cottontail' );
	do_settings_sections( 'raffle-block' );
	submit_button();
	$settings = ob_get_clean();

	$output = '<div class="wrap">';
	$output .= sprintf( '<h1>%s</h1>', 'Raffle Block Options' );
	$output .= '<form action="options.php" method="post">';
	$output .= $settings;
	$output .= '</form>';
	$output .= '</div>';

	echo $output;
}

function raffle_block_developer_mode_instructions() {
	echo '<p>"Developer Mode" prevents the plugin&rsquo;s stylesheet from being loaded on the front-end.</p>';
}

function raffle_block_developer_mode_fields() {
	$options = get_option( 'raffle_block_options' );
	$checked = '';

	/**
	 * `$options` is empty if developer mode is not set. i think
	 * this might be because there's only one option under that
	 * key. something to be aware of.
	 */
	if ( ! empty( $options ) ) {
		$checked = 'checked';
	}
	echo sprintf( '<input id="for_developer_mode" name="raffle_block_options[developer_mode]" type="checkbox" %s />', $checked );
}

<?php

/*
 * Plugin Name: Elementor Widgets
 * Description: Some new Elementor widgets
 * Version:     1.0
 */

class Elementor_Widgets {

	protected static $instance = null;

	protected $elementor_widgets = array(
		'before-after-slider' => '\Elementor\Before_After_Slider',
		'custom-search-form' => '\ElementorPro\Modules\ThemeElements\Widgets\Custom_Search_Form',
	);

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
        foreach($this->elementor_widgets as $slug => $className)
        {
            require_once("widgets/{$slug}.php");
        }
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}

	public function register_widgets() {
        foreach($this->elementor_widgets as $className)
        {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $className() );
        }
	}

}
add_action( 'init', 'elementor_widgets_init' );

function elementor_widgets_init() {
	Elementor_Widgets::get_instance();
}
<?php

/*
 * Plugin Name: Fil Elementor Widgets
 * Description: Some new Elementor widgets
 * Version:     1.0.1
 * Author:      Filipe Duarte
 * Author URI:  https://filduarte.com.br
 * License:     GPL-2.0+
 * Text Domain: elementor-widgets
 */

define( 'FEW_PLUGIN_NAME', 'Fil Elementor Widgets');
define( 'FEW_PLUGIN_SLUG', 'fil-elementor-widgets');
define( 'FEW_ELEMENTOR_WIDGETS',
		array(
			'before-after-slider'	=> '\Elementor\Before_After_Slider',
			'masked-element'		=> '\Elementor\Masked_Element',
			'posts-with-menu'		=> '\Elementor\Posts_With_Menu',
			'custom-search-form'	=> '\ElementorPro\Modules\ThemeElements\Widgets\Custom_Search_Form',
		)
);

function check_elementor() {
	if ( is_plugin_active( 'elementor/elementor.php' ) ) {
		add_action( 'elementor/widgets/register', 'few_register_widgets' );
		add_action( 'elementor/elements/categories_registered', 'few_add_widget_categories' );
	}
}

add_action( 'admin_init', 'check_elementor' );

function few_register_widgets( $widgets_manager ) {
	foreach(FEW_ELEMENTOR_WIDGETS as $slug => $className)
	{
		require_once( __DIR__ . "/widgets/{$slug}.php");
		$widgets_manager->register( new $className() );
	}
}

function few_add_widget_categories( $elements_manager ) {
	$elements_manager->add_category(
		FEW_PLUGIN_SLUG,
		[
			'title' => esc_html__( 'F.E.W.', FEW_PLUGIN_SLUG ),
			'icon' => 'eicon-apps',
		]
	);
}
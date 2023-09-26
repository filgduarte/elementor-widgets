<?php
namespace Elementor;

class Before_After_Slider extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_script( 'before-after-slider', plugin_dir_url( __FILE__ ) . '/assets/js/before-after-slider.js', [ 'elementor-frontend' ], '1.0.0', true );
        wp_register_style( 'before-after-slider', plugin_dir_url( __DIR__ ) . '/assets/css/before-after-slider.css' );
    }

    public function get_script_depends() {
        return [ 'before-after-slider' ];
    }

    public function get_style_depends() {
        return [ 'before-after-slider' ];
    }
	
	public function get_name() {
		return 'before-after-slider';
	}
	
	public function get_title() {
		return __('Before/After Slider', FEW_PLUGIN_SLUG);
	}
	
	public function get_icon() {
		return 'eicon-column';
	}
	
	public function get_categories() {
		return [ FEW_PLUGIN_SLUG ];
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Content', 'elementor' ),
			]
		);
		
		$this->add_control(
			'before_image',
			[
				'label' => __( 'Before', FEW_PLUGIN_SLUG ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'before',
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);

        $this->add_control(
			'after_image',
			[
				'label' => __( 'After', FEW_PLUGIN_SLUG ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'after',
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);

		$this->end_controls_section();
	}
	
	protected function render() {
        $settings = $this->get_settings_for_display();
		
		if( ! empty( $settings['before_image'] ) ) {
            $before_image = Group_Control_Image_Size::get_attachment_image_html( $settings, 'before', 'before_image' );
        }
    
        if( ! empty( $settings['after_image'] ) ) {
            $after_image = Group_Control_Image_Size::get_attachment_image_html( $settings, 'after', 'after_image' );
        }

?>
	<div class="few-bas__container">
		<div class="few-bas-after">
            <?php echo $after_image; ?>
        </div>
		<div class="few-bas-before">
            <?php echo $before_image; ?>
        </div>
        <div class='few-bas-slider-button'>
            <div class="few-bas-slider-icon">
                <i class="fas fa-arrows-alt-h"></i>
            </div>
        </div>
		<input type="range" name='few-bas-slider' min="0" max="100" value="50" class="few-bas-slider">
	</div>
<?php
	}
	
	protected function _content_template() {

    }	
}
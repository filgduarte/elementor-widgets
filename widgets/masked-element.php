<?php
namespace Elementor;

if ( class_exists( 'Elementor\Widget_Base' ) )
{

class Masked_Element extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    }
	
	public function get_name() {
		return 'masked-element';
	}
	
	public function get_title() {
		return __('Masked Element', 'fil-elementor-widgets');
	}
	
	public function get_icon() {
		return 'eicon-star';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Content', 'elementor' ),
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .few-masked-element',
			]
		);

        $this->add_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'fil-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .few-masked-element' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'fil-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .few-masked-element' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'mask_image',
			[
				'label' => __( 'Máscara', 'fil-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'selectors' => [
                    '{{WRAPPER}} .few-masked-element' => 'mask-image: url({{URL}});-webkit-mask-image: url({{URL}});',
                ],
			]
		);

		$this->add_control(
			'mask_position',
			[
				'label' => esc_html__( 'Mask position', 'fil-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'' => esc_html__( 'Default', 'fil-elementor-widgets' ),
					'center center' => esc_html__( 'Center', 'fil-elementor-widgets' ),
					'center left'  => esc_html__( 'Center left', 'fil-elementor-widgets' ),
					'center right' => esc_html__( 'Center right', 'fil-elementor-widgets' ),
					'top center' => esc_html__( 'Top center', 'fil-elementor-widgets' ),
                    'top left' => esc_html__( 'Top left', 'fil-elementor-widgets' ),
                    'top right' => esc_html__( 'Top right', 'fil-elementor-widgets' ),
                    'bottom center' => esc_html__( 'Bottom center', 'fil-elementor-widgets' ),
                    'bottom left' => esc_html__( 'Bottom left', 'fil-elementor-widgets' ),
                    'bottom right' => esc_html__( 'Bottom right', 'fil-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .few-masked-element' => 'mask-position: {{VALUE}};-webkit-mask-position: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'mask_size',
			[
				'label' => esc_html__( 'Mask size', 'fil-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'' => esc_html__( 'Default', 'fil-elementor-widgets' ),
					'auto' => esc_html__( 'Auto', 'fil-elementor-widgets' ),
					'contain'  => esc_html__( 'Contain', 'fil-elementor-widgets' ),
					'cover' => esc_html__( 'Cover', 'fil-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .few-masked-element' => 'mask-size: {{VALUE}};-webkit-mask-size: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'mask_repeat',
			[
				'label' => esc_html__( 'Repeat mask', 'fil-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => [
					'' => esc_html__( 'Default', 'fil-elementor-widgets' ),
					'no-repeat' => esc_html__( 'No repeat', 'fil-elementor-widgets' ),
                    'repeat' => esc_html__( 'Repeat', 'fil-elementor-widgets' ),
					'repeat-x'  => esc_html__( 'Repeat horizontal', 'fil-elementor-widgets' ),
					'repeat-y' => esc_html__( 'Repeat vertical', 'fil-elementor-widgets' ),
					'space' => esc_html__( 'Space', 'fil-elementor-widgets' ),
					'round' => esc_html__( 'Round', 'fil-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .few-masked-element' => 'mask-repeat: {{VALUE}};-webkit-mask-repeat: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}
	
	protected function render() {
        $settings = $this->get_settings_for_display();

?>
	<div class="few-masked-element"></div>
<?php
	}
	
	protected function _content_template() {

    }	
}

}
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
		return __('Masked Element', FEW_PLUGIN_SLUG);
	}
	
	public function get_icon() {
		return 'eicon-star';
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
				'label' => esc_html__( 'Width', FEW_PLUGIN_SLUG ),
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
				'label' => esc_html__( 'Height', FEW_PLUGIN_SLUG ),
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
				'label' => __( 'Máscara', FEW_PLUGIN_SLUG ),
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
			'mask_mode',
			[
				'label' => esc_html__( 'Mask mode', FEW_PLUGIN_SLUG ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'alpha',
				'options' => [
					'' => esc_html__( 'Default', FEW_PLUGIN_SLUG ),
					'alpha' => esc_html__( 'Alpha', FEW_PLUGIN_SLUG ),
					'luminance'  => esc_html__( 'Luminance', FEW_PLUGIN_SLUG ),
					'match-source' => esc_html__( 'Match Source', FEW_PLUGIN_SLUG ),
				],
				'selectors' => [
					'{{WRAPPER}} .few-masked-element' => 'mask-mode: {{VALUE}};-webkit-mask-mode: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mask_position',
			[
				'label' => esc_html__( 'Mask position', FEW_PLUGIN_SLUG ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'' => esc_html__( 'Default', FEW_PLUGIN_SLUG ),
					'center center' => esc_html__( 'Center', FEW_PLUGIN_SLUG ),
					'center left'  => esc_html__( 'Center left', FEW_PLUGIN_SLUG ),
					'center right' => esc_html__( 'Center right', FEW_PLUGIN_SLUG ),
					'top center' => esc_html__( 'Top center', FEW_PLUGIN_SLUG ),
                    'top left' => esc_html__( 'Top left', FEW_PLUGIN_SLUG ),
                    'top right' => esc_html__( 'Top right', FEW_PLUGIN_SLUG ),
                    'bottom center' => esc_html__( 'Bottom center', FEW_PLUGIN_SLUG ),
                    'bottom left' => esc_html__( 'Bottom left', FEW_PLUGIN_SLUG ),
                    'bottom right' => esc_html__( 'Bottom right', FEW_PLUGIN_SLUG ),
				],
				'selectors' => [
					'{{WRAPPER}} .few-masked-element' => 'mask-position: {{VALUE}};-webkit-mask-position: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'mask_size',
			[
				'label' => esc_html__( 'Mask size', FEW_PLUGIN_SLUG ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'' => esc_html__( 'Default', FEW_PLUGIN_SLUG ),
					'auto' => esc_html__( 'Auto', FEW_PLUGIN_SLUG ),
					'contain'  => esc_html__( 'Contain', FEW_PLUGIN_SLUG ),
					'cover' => esc_html__( 'Cover', FEW_PLUGIN_SLUG ),
				],
				'selectors' => [
					'{{WRAPPER}} .few-masked-element' => 'mask-size: {{VALUE}};-webkit-mask-size: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'mask_repeat',
			[
				'label' => esc_html__( 'Repeat mask', FEW_PLUGIN_SLUG ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => [
					'' => esc_html__( 'Default', FEW_PLUGIN_SLUG ),
					'no-repeat' => esc_html__( 'No repeat', FEW_PLUGIN_SLUG ),
                    'repeat' => esc_html__( 'Repeat', FEW_PLUGIN_SLUG ),
					'repeat-x'  => esc_html__( 'Repeat horizontal', FEW_PLUGIN_SLUG ),
					'repeat-y' => esc_html__( 'Repeat vertical', FEW_PLUGIN_SLUG ),
					'space' => esc_html__( 'Space', FEW_PLUGIN_SLUG ),
					'round' => esc_html__( 'Round', FEW_PLUGIN_SLUG ),
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
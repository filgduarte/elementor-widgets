<?php
namespace Elementor;

class Posts_With_Menu extends Widget_Base {
	
	public function get_name() {
		return 'posts-with-menu';
	}
	
	public function get_title() {
		return __('Posts com menu', 'nina-moraes');
	}
	
	public function get_icon() {
		return 'eicon-posts-grid';
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
		
		$categories = get_categories( array(
			'orderby' => 'name',
			'order'   => 'ASC'
		) );
		$cat_options = [];
		foreach ( $categories as $category ) {
			$cat_options[ $category->slug ] = $category->name;
		}
		
		$menus = wp_get_nav_menus(); 
		$menu_options = [];
		foreach ( $menus as $menu ) {
			$menu_options[ $menu->term_id ] = $menu->name;
		}
		
		$this->add_control(
			'category',
			[
				'label' => __( 'Categoria principal', 'nina-moraes' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
                'options' => $cat_options,
			]
		);

		$this->add_control(
			'subcategory',
			[
				'label' => __( 'Categoria secundária', 'nina-moraes' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
                'options' => $cat_options,
			]
		);
		
		$this->add_control(
			'menu_type',
			[
				'label' => __( 'Tipo de menu', 'nina-moraes' ),
				'description' => __( 'Defina se deseja utilizar um menu já criado ou gerar um composto por categorias de posts a sua escolha.', 'nina-moraes' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'menu' => [
						'title' => __( 'Menu', 'nina-moraes' ),
						'icon' => 'fa fa-list-alt',
					],
					'category' => [
						'title' => __( 'Categorias', 'nina-moraes' ),
						'icon' => 'fa fa-tags',
					],
				],
				'default' => 'menu',
				'toggle' => false,
			]
		);
		
		$this->add_control(
			'menu_filters',
			[
				'label' => __( 'Menu', 'nina-moraes' ),
				'description' => __( 'Selecione o menu a ser utilizado.', 'nina-moraes' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
                'options' => $menu_options,
				'default' => [],
				'condition' => [
					'menu_type' => 'menu'
				],
			]
		);

		$this->add_control(
			'cat_filters',
			[
				'label' => __( 'Categorias do menu', 'nina-moraes' ),
				'description' => __( 'Selecione as categorias que irão compor o menu.', 'nina-moraes' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
                'options' => $cat_options,
				'default' => [],
				'multiple' => true,
				'condition' => [
					'menu_type' => 'category'
				],
			]
		);
		
		$this->add_control(
			'category_color',
			[
				'label' => __( 'Cor da categoria', 'nina-moraes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#777777',
				'selectors' => [
					'{{WRAPPER}} .pwm-menu__arrow' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'multi_page',
			[
				'label' => __( 'Múltiplas páginas?', 'nina-moraes' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Sim', 'nina-moraes' ),
				'label_off' => __( 'Não', 'nina-moraes' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}
	
	protected function render() {
        $settings = $this->get_settings_for_display();
		
		$category = $settings['category'];
		$subcategory = $settings['subcategory'];
		$multi_page = !empty($settings['multi_page']);

		if (!$multi_page)
		{
			if ( isset($_GET['category']) ) {
				$category = sanitize_text_field( $_GET['category'] );
			}

			if ( isset($_GET['subcategory']) ) {
				$subcategory = sanitize_text_field( $_GET['subcategory'] );
			}
		}
		
		if ( empty($category) )
		{
			return;
		}
?>
	<div class="pwm-menu" data-category="<?php echo $category; ?>" data-subcategory="<?php echo $subcategory; ?>">
		<div class="pwm-menu__arrow"></div>
		<div class="pwm-menu__container">
<?php
		if ( $settings['menu_type'] == 'category' )
		{
			$item_class = "menu-item";
		
			if ( empty($subcategory) )
			{
				$subcategory = "todos";
				$item_class .= " current-menu-item";
			}
?>
			<ul class="pwm-menu__list menu">
				<li class="<?php echo $item_class; ?>">
					<a href="<?php echo $this->pwm_generate_url($category, $multi_page); ?>"><?php esc_attr_e( 'Todos', 'nina-moraes' ); ?></a>
				</li>
<?php
			foreach ( $settings['cat_filters'] as $filter )
			{
				$category_obj = get_term_by('slug', $filter, 'category');
				$item_class = "menu-item";
				if ($filter == $subcategory)
				{
					$item_class .= " current-menu-item";
				}
?>
				<li class="<?php echo $item_class; ?>">
					<a href="<?php echo $this->pwm_generate_url($category, $filter, $multi_page); ?>"><?php echo $category_obj->name ?></a>
				</li>
<?php
			}
?>
			</ul>
<?php
		}
		else // if ( $settings['menu_type'] != 'category' )
		{
			$menu = $settings['menu_filters'];
			wp_nav_menu( array(
   				'menu' => $menu,
				'container' => false,
				'menu_class' => 'pwm-menu__list menu'
			) );
			
		}
?>
		</div>
	</div>
<?php
		
		$query_categories = $category;
		if ( $subcategory != "todos")
		{
			$query_categories .= "+" . $subcategory;
		}

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = array(
			'category_name'	=> $query_categories,
			'posts_per_page'=> 12,
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC',
			'paged'			=> $paged
		);
		$the_query = new \WP_Query( $args );
		if ( $the_query->have_posts() ) {
?>
			<div class="pwm-loop">
<?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
?>
				<div class="pwm-post">
					<div class="pwm-post__thumbnail">
						<?php the_post_thumbnail('full'); ?>
					</div>
					<div class="pwm-post__title">
<?php
						echo '<a href="' . get_permalink( get_the_ID() ) . '">' . get_the_title() . '</a>';
?>
					</div>
				</div>
<?php
			}
?>
			</div>
			<nav class="woocommerce-pagination">
<?php
			$GLOBALS['wp_query']->max_num_pages = $the_query->max_num_pages;
			the_posts_pagination( array(
				'type'		=> 'list',
				'mid_size'  => 2,
				'prev_text' => __( '←', 'nina-moraes' ),
				'next_text' => __( '→', 'nina-moraes' ),
			) );
?>
			</nav>
<?php
		} else {
			echo "Nada encontrado";
		}

		/* Restore original Post Data */
		wp_reset_postdata();		
	}
	
	protected function _content_template() {

    }
	
	public function pwm_generate_url($category, $subcategory = '', $multi_page = FALSE)
	{
		global $wp;
		$url = "";

		if ($multi_page == TRUE)
		{
			$url = get_option( 'siteurl' ) . "/" . $category;
			if ( !empty($subcategory) )
			{
				$url .= "-" . $subcategory;
			}
		}
		else
		{
			$url = home_url( $wp->request ) . "/?category=" . $category;
			if ( !empty($subcategory) )
			{
				$url .= "&subcategory=" . $subcategory;
			}
		}
		
		return $url;
	}
	
	
}
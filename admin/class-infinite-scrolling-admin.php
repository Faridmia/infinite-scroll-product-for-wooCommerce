<?php
class Ispfw_Infinite_Ispfw_Woo_Admin
{

    private $plugin_name;

    private $version;

    public $animation_style;

    public $infinite_sp_woo_setting_api;

    public function __construct($plugin_name, $version)
    {
        $this->infinite_sp_woo_admin_setting_page_callback();
        $this->infinite_sp_woo_setting_api = new Ispfw_Infinite_Woo_Setting_Option();
        $this->plugin_name = $plugin_name;

        $this->version = $version;


        add_action('admin_init', array($this, 'Ispfw_infinite_scroll_setting_admin_init'));
        add_action('admin_menu', array($this, 'infinite_sp_woo_add_menu'));
    }

    /**
     * Added setting page
     *
     * @since    1.0.0
     */
    public function infinite_sp_woo_admin_setting_page_callback()
    {
        include_once 'partials/infinite-scrolling-woo-admin-display.php';
    }

    public function Ispfw_infinite_scroll_setting_admin_init()
    {

        //set the settings
        $this->infinite_sp_woo_setting_api->ispfw_set_sections($this->get_infinite_sp_woo_settings_sections());
        $this->infinite_sp_woo_setting_api->ispfw_set_fields($this->get_infinite_sp_woo_settings_fields());

        //initialize settings
        $this->infinite_sp_woo_setting_api->ispfw_admin_init();
    }

    public function get_infinite_sp_woo_settings_sections()
    {
        $sections = array(
            array(
                'id'    => 'infinite_sp_woo_inf_basics',
                'title' => __('General Settings', 'infinite-scroll-woo'),
            ),
            array(
                'id'    => 'infinite_sp_woo_inf_color',
                'title' => __('Advanced Settings', 'infinite-scroll-woo'),
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public function get_infinite_sp_woo_settings_fields()
    {


        $tab_infinite_sp_woo_settings_fields = array(
            'infinite_sp_woo_inf_basics' => array(
                array(
                    'name'  => 'infinite_sp_pagination_on_off',
                    'label' => __('Status ON/OFF', 'infinite-scroll-woo'),
                    'desc'  => __('When uncheck the box then pagination off ', 'infinite-scroll-woo'),
                    'type'  => 'checkbox',
                    'default' => ''
                ),
                array(
                    'name'    => 'infinite_sp_pagination_type',
                    'label'   => __('Pagination Type', 'infinite-scroll-woo'),
                    'desc'    => __('Choose Your pagination type', 'infinite-scroll-woo'),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'infinite_scrolling' => 'Infinite Scroll',
                        'infinite_ajax_select'  => 'Ajax Pagination',
                        'infinite_load_more_btn'  => 'Load More'
                    )
                ),
                array(
                    'name'              => 'infinite_sp_content_selector',
                    'label'             => __('Content Selector', 'infinite-scroll-woo'),
                    'default'           => __('ul.products-block-post-template', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'              => 'infinite_sp_woo_item_selector',
                    'label'             => __('Loop Item Selector', 'infinite-scroll-woo'),
                    'default'           => __('li.product', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'              => 'infinite_sp_woo_prev_selector',
                    'label'             => __('Prev Selector', 'infinite-scroll-woo'),
                    'default'           => __('.wp-block-query-pagination', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'              => 'infinite_sp_woo_next_selector',
                    'label'             => __('Next Selector', 'infinite-scroll-woo'),
                    'default'           => __('.wp-block-query-pagination .wp-block-query-pagination-next', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),

                array(
                    'name'    => 'infinite_loader_image',
                    'label'   => __('Loader Image', 'infinite-scroll-woo'),
                    'desc'    => __('File description', 'infinite-scroll-woo'),
                    'type'    => 'file',
                    'default' => '',
                    'size'              => '15px',
                    'options' => array(
                        'button_label' => 'Loader Image'
                    )
                ),
                array(
                    'name'              => 'infinite_loading_btn_text',
                    'label'             => __('Loading Button Text', 'infinite-scroll-woo'),
                    'default'           => __('Loading...', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'              => 'infinite_load_more_btn_text',
                    'label'             => __('Load More Button Text', 'infinite-scroll-woo'),
                    'default'           => __('Load More Products', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'              => 'infinite_isp_per_page',
                    'label'             => __('Products Per Page', 'infinite-scroll-woo'),
                    'default'           => __('', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),

                array(
                    'name'              => 'infinite_isp_per_row_products',
                    'label'             => __('Products Per Row', 'infinite-scroll-woo'),
                    'default'           => __('', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),



            ),
            'infinite_sp_woo_inf_color'  => array(

                array(
                    'name'  => 'infinite_scroll_to_top_enable',
                    'label' => __('Scroll Top Enable?', 'infinite-scroll-woo'),
                    'desc'  => __('When uncheck the box then Scroll to Top Disable ', 'infinite-scroll-woo'),
                    'type'  => 'checkbox',
                    'default' => ''
                ),
                array(
                    'name'              => 'infinite_scroll_totop',
                    'label'             => __('Scroll To', 'infinite-scroll-woo'),
                    'default'           => __('html, body', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'              => 'infinite_sp_woo_buffer_pixels',
                    'label'             => __('Buffer  Pixel', 'infinite-scroll-woo'),
                    'default'           => __('50', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),

                array(
                    'name'    => 'infinite_sp_animation',
                    'label'   => __('Animation', 'infinite-scroll-woo'),
                    'desc'    => __('It Works after loading  products', 'infinite-scroll-woo'),
                    'type'    => 'select',
                    'default' => 'none',
                    'options' => $this->infinite_animation_func()
                ),

                array(
                    'name'              => 'infinite_load_more_padding',
                    'label'             => __('Load More Button Padding', 'infinite-scroll-woo'),
                    'default'           => __('12px 18px', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'              => 'infinite_sp_woo_border_radius',
                    'label'             => __('Button Border Radius', 'infinite-scroll-woo'),
                    'default'           => __('5px', 'infinite-scroll-woo'),
                    'type'              => 'text',
                    'size'              => '15px',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'  => 'isp_load_more_bg_color',
                    'label' => __('Load More Background', 'infinite-scroll-woo'),
                    'type'  => 'color',
                ),
                array(
                    'name'  => 'isp_load_more_text_color',
                    'label' => __('Load More Text', 'infinite-scroll-woo'),
                    'type'  => 'color',
                ),
                array(
                    'name'  => 'isp_load_more_border_color',
                    'label' => __('Load More Border color', 'infinite-scroll-woo'),
                    'type'  => 'color',
                ),
            ),
        );

        return $tab_infinite_sp_woo_settings_fields;
    }

    public function infinite_animation_func()
	{
        $animation_array = array(
			'none'		=>	'none',
			'bounce'		=>	'Bounce',
			'flash'			=>	'flash',
			'pulse'			=>	'pulse',
			'rubberBand'	=>	'rubberBand',
			'shake'			=>	'shake',
			'swing'			=>	'swing',
			'tada'			=>	'tada',
			'bounce'		=>	'bounce',
			'wobble'		=>	'wobble',
			'headShake'		=>	'headShake',
			'Jello'			=>	'headShake',
			'fadeIn'		=>	'Fade In',
			'fadeInDown'	=>	'Fade In Down',
			'fadeInLeft'	=>	'pulse',
			'fadeInRight'	=>	'Fade In Right',
			'fadeInUp'		=>	'Fade In Up',
			'zoomIn'		=>	'zoomIn',
			'zoomInDown'	=>	'zoomInDown',
			'zoomInLeft'	=>	'zoomInLeft',
			'zoomInRight'	=>	'zoomInRight',
			'zoomInUp'		=>	'zoomInUp',
			'bounceIn'		=>	'bounceIn',
			'bounceInDown'	=>	'bounceInDown',
			'bounceInLeft'	=>	'bounceInLeft',
			'bounceInRight'	=>	'bounceInRight',
			'bounceInUp'	=>	'bounceInUp',
			'slideInDown'	=>	'slideInDown',
			'slideInLeft'	=>	'slideInLeft',
			'slideInRight'	=>	'slideInRight',
			'slideInUp'	    =>	'slideInUp',
			'slideInDown'	=>	'slideInDown',
			'slideInLeft'	=>	'slideInLeft',
			'slideInRight'	=>	'slideInRight',
			'slideInUp'	    =>	'slideInUp',
			'rotateIn'			=>	'rotateIn',
			'rotateInDownLeft'	=>	'rotateInDownLeft',
			'rotateInDownRight'	=>	'rotateInDownRight',
			'rotateInUpLeft'	=>	'rotateInUpLeft',
			'rotateInUpRight'	=>	'rotateInUpRight',
			'lightSpeedIn'			=>	'lightSpeedIn',
			'rollIn'			=>	'rollIn',
		);

        $this->animation_style = $animation_array;

        return $this->animation_style;
	}

    /**
     * add admin menu
     *
     * @since    1.0.0
     */
    public function infinite_sp_woo_add_menu()
    {

        add_menu_page(
            __('Infinite Scrolling', 'infinite-scroll-woo'),
            __('Infinite Scrolling', 'infinite-scroll-woo'),
            'manage_options',
            'infinite-scrolling-option-setting',
            array($this, 'infinite_sp_woo_menu_callback'),
            'dashicons-layout',
            "111"
        );
    }

    public function infinite_sp_woo_menu_callback()
    { ?>
        <div class="cdt-wrap">
            <?php
            $this->infinite_sp_woo_setting_api->ispfw_infinite_sp_woo_show_navigation();
            $this->infinite_sp_woo_setting_api->ispfw_infinite_scrolling_show_forms();
            ?>

        </div>
<?php }

    public function infinite_sp_woo_enqueue_styles()
    {
        wp_enqueue_style('wp-color-picker');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function infinite_sp_woo_enqueue_scripts()
    {

        wp_enqueue_script('wp-color-picker');
        wp_enqueue_media();
    }
}

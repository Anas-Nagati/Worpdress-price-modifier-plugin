<?php 
/**
 * @package  Price_ModifierPlugin
 */

namespace Inc\Api;

class SettingsApi
{
	public $admin_pages = array();

	public $admin_subpages = array();

	public $settings = array();

	public $sections = array();

	public $fields = array();

	public function register()
	{
		if ( ! empty($this->admin_pages) ) {
			add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
		}

		if ( !empty($this->settings) ) {
			add_action( 'admin_init', array( $this, 'registerCustomFields' ) );
		}

	/*	add_action( 'admin_menu', array( $this, 'price_modifying' ));*/
	}

	public function addPages( array $pages )
	{
		$this->admin_pages = $pages;

		return $this;
	}

	public function withSubPage( string $title = null ) 
	{
		if ( empty($this->admin_pages) ) {
			return $this;
		}

		$admin_page = $this->admin_pages[0];

		$subpage = array(
			array(
				'parent_slug' => $admin_page['menu_slug'], 
				'page_title' => $admin_page['page_title'], 
				'menu_title' => ($title) ? $title : $admin_page['menu_title'], 
				'capability' => $admin_page['capability'], 
				'menu_slug' => $admin_page['menu_slug'], 
				'callback' => $admin_page['callback']
			)
		);

		$this->admin_subpages = $subpage;

		return $this;
	}

	public function addSubPages( array $pages )
	{
		$this->admin_subpages = array_merge( $this->admin_subpages, $pages );

		return $this;
	}

	public function addAdminMenu()
	{
		foreach ( $this->admin_pages as $page ) {
			add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
		}

		foreach ( $this->admin_subpages as $page ) {
			add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
		}
	}

	public function setSettings( array $settings )
	{
		$this->settings = $settings;

		return $this;
	}

	public function setSections( array $sections )
	{
		$this->sections = $sections;

		return $this;
	}

	public function setFields( array $fields )
	{
		$this->fields = $fields;

		return $this;
	}
/*
public 	function price_modifying()
	{
		$args = array( 'post_type' => array( 'product','product-variation' ), 'nopaging' => true, 'sortby' => 'post_type', 'order' => 'desc' );

		$all_products = new WP_Query( $args );

		if ( $all_products->have_posts() ) :
			while ( $all_products->have_posts() ) :

				$all_products->the_post();
				$id = get_the_ID();
				$discount_rate = get_option('Price_Modifier_rate');

				$sale_price = get_post_meta($id, '_sale_price', true);

				if(!empty($discount_rate) && !empty($sale_price)){

					echo '';

				}elseif (!empty($discount_rate) && empty($sale_price) ){

					$orig = get_post_meta( $id, $key = '_regular_price' , false);
					foreach($orig as $value){

						$priceafter = $value - ($value  * ($discount_rate/100 )) ;

						global $value;

						update_post_meta( $id, '_price', $priceafter);

						update_post_meta( $id, '_sale_price', $priceafter);

					}
				}elseif(empty($discount_rate) && !empty($sale_price)){
					$orig = get_post_meta( $id, $key = '_regular_price' , false);

					foreach($orig as $value) {

						$pricebefore = $value ;

						global $value;

						update_post_meta( $id, '_price', $pricebefore );

						update_post_meta( $id, '_sale_price', '');

					}
				}
				if( has_term( 'variable', 'product_type', $id ) ){
					variable_product_sync( $id );
				}

			endwhile;
		endif;

		wp_reset_postdata();
	}

*/
	public function registerCustomFields()
	{
		// register setting
		foreach ( $this->settings as $setting ) {
			register_setting( $setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : '' ) );
		}

		// add settings section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
		}

		// add settings field
		foreach ( $this->fields as $field ) {
			add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
		}
	}
}
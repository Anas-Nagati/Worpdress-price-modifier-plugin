<?php 
/**
 * @package  Price_ModifierPlugin
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use inc\Api\query;

/**
* 
*/
class Admin extends BaseController
{
	public $settings;

	public $callbacks;

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();



		$this->setPages();

		$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Price Modifier',
				'menu_title' => 'Price_Modifier', 
				'capability' => 'manage_options', 
				'menu_slug' => 'Price_Modifier_plugin', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-store', 
				'position' => 110
			)
		);
	}

	public function setSubpages()
	{
		$this->subpages = array(
			/*array(
				'parent_slug' => 'Price_Modifier_plugin', 
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'Price_Modifier_cpt', 
				'callback' => array( $this->callbacks, 'adminCpt' )
			),
			array(
				'parent_slug' => 'Price_Modifier_plugin', 
				'page_title' => 'Custom Taxonomies', 
				'menu_title' => 'Taxonomies', 
				'capability' => 'manage_options', 
				'menu_slug' => 'Price_Modifier_taxonomies', 
				'callback' => array( $this->callbacks, 'adminTaxonomy' )
			),
			array(
				'parent_slug' => 'Price_Modifier_plugin', 
				'page_title' => 'Custom Widgets', 
				'menu_title' => 'Widgets', 
				'capability' => 'manage_options', 
				'menu_slug' => 'Price_Modifier_widgets', 
				'callback' => array( $this->callbacks, 'adminWidget' )
			)*/
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'Price_Modifier_options_group',
				'option_name' => 'Price_Modifier_rate',
				'callback' => array( $this->callbacks, 'Price_ModifierOptionsGroup' )
			),
			array(
				'option_group' => 'Price_Modifier_options_group',
				'option_name' => 'first_name'
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'Price_Modifier_admin_index',
				'title' => 'Settings',
				'callback' => array( $this->callbacks, 'Price_Modifier_AdminSection' ),
				'page' => 'Price_Modifier_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'Price_Modifier_rate',
				'title' => 'Price Modifier rate',
				'callback' => array( $this->callbacks, 'Price_Modifier' ),
				'page' => 'Price_Modifier_plugin',
				'section' => 'Price_Modifier_admin_index',
				'args' => array(
					'label_for' => 'Price_Modifier_rate',
					'class' => 'example-class'
				)
			),
			/*array(
				'id' => 'first_name',
				'title' => 'First Name',
				'callback' => array( $this->callbacks, 'Price_ModifierFirstName' ),
				'page' => 'Price_Modifier_plugin',
				'section' => 'Price_Modifier_admin_index',
				'args' => array(
					'label_for' => 'first_name',
					'class' => 'example-class'
				)
			)*/
		);

		$this->settings->setFields( $args );
	}
}
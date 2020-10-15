<?php 
/**
 * @package  Price_ModifierPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}



	public function Price_ModifierOptionsGroup( $input )
	{
		return $input;
	}

	public function Price_Modifier_AdminSection()
	{
		echo 'Here you can write your discount rate.';

	}

	public function Price_Modifier()
	{
		$value = esc_attr( get_option( 'Price_Modifier_rate' ) );
		echo '<input type="text" class="regular-text" name="Price_Modifier_rate" value="' . $value . '" placeholder="ex: 20">';
		echo '<br>'.'<br>'.'*in case you needed to decrease prices just use  -  before the number '.'<br>'.'ex: 5 will add a 5% increase in prices of all products';

	}

}

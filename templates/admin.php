<div class="wrap">
	<h1>Price Modifier Plugin</h1>
	<?php settings_errors(); ?>

	<form method="post" action="options.php">
		<?php 
			settings_fields( 'Price_Modifier_options_group' );
			do_settings_sections( 'Price_Modifier_plugin' );
			submit_button();
		?>
	</form>
</div>

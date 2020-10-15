<?php

function price_modifying()
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

					$priceafter = $value + ($value  * ($discount_rate/100 )) ;

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
add_action( 'admin_menu',  'price_modifying' );

<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;

switch ($woocommerce_loop['columns']) {
	case '2':
			$coll=6;
		break;
	case '3':
			$coll=4;
		break;
	case '4':
			$coll=3;
		break;
	case '12':
			$coll=1;
		break;
	
	default:
			$coll=12;
		break;
}

?>
<div class="col-sm-<?php print $coll;?> product-category product<?php
    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
        echo ' first';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' last';
	?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="thumbnail-container">

	<?php
		/**
		 * woocommerce_after_subcategory_title hook
		 */
		do_action( 'woocommerce_after_subcategory_title', $category );
	?>
		<?php

		$small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
		$dimensions    			= wc_get_image_size( $small_thumbnail_size );
		$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
			$image = $image[0];
		} else {
			$image = wc_placeholder_img_src();
		}

		if ( $image )
			echo '<img class"img-responsive" src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" />';


		?>


	<div class="text-description">
		<h3><?php echo $category->name;?></h3>
		<?php
			if ( $category->count > 0 )
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="number">' . ($category->count?($category->count==1?sprintf(__('%d item','detheme'),$category->count):sprintf(__('%d items','detheme'),$category->count)):__('none','detheme')) . '</mark>', $category );
		?>
	</div>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</div>
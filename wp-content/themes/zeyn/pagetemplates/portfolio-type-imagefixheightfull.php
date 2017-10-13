<?php
/**
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Zeyn
 * @since Zeyn 1.0
 */

global $detheme_config,$paged,$rowid;


$post_per_page=4;

$rowid=array();

$navigations=array();

function filterRow($k){
	global $rowid;

	if(in_array($k->ID,$rowid))
		return false; 
	
	array_push($rowid,$k->ID);
	
	return $k;
}

$post_portfolios=array();

$column=get_query_var('column');


				$queryargs = array(
		                'post_type' => 'port',
						'no_found_rows' => false,
						'posts_per_page'=>$post_per_page,
						'paged'=>1
					);

	
				$query = new WP_Query( $queryargs );	
				$max_page=$query->max_num_pages;

				if ( $query->have_posts() ) :

				while ( $query->have_posts() ) : 
				
						$query->the_post();
						
						ob_start();

						get_template_part( 'content-portfolio-imagefixheightfull');
						$post_portfolios[]=ob_get_contents();
						ob_end_clean();

						
				endwhile;

				endif;

			wp_reset_query();


if(count($post_portfolios)):?>

<div class="portfolio">
<div class="container">
</div>
<div class="row" >
	<div id="portfolios" data-type="imagefixheightfull" data-col="<?php print $column;?>" class="portfolio-container">
<?php 	if(count($post_portfolios)):
			
			print @implode("",$post_portfolios);
		
		endif;
	
?>
	</div>
<?php if($max_page > 1):?>
	<div class="portfolio-navigation">
<?php
			$permalink = (bool)get_option('permalink_structure');

			$nav_link=add_query_arg( 'page',2, get_post_type_archive_link('port'));
			$nav_link=add_query_arg( 'posts_per_page',$post_per_page, $nav_link);

			print '<a class="button btn-more more-post" href="'.esc_url($nav_link).'page=2">'.__('Load More','detheme').'</a>'."\n";
	
			?>
	</div>
<?php endif;?>
</div>

</div>
<?php endif;
?>
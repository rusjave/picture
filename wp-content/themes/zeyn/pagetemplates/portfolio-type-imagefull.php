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


$post_per_page=3;

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


$args = array(
  'orderby' => 'name',
  'show_count' => 0,
  'pad_counts' => 0,
  'hierarchical' => 0,
  'taxonomy' => 'portcat',
  'title_li' => ''
);

$column=get_query_var('column');

$categories=get_categories($args);

$navbar="";

if($categories && count($categories)){

	$navbar.='<nav id="featured-work-navbar" class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#dt-featured-filter">
      <span class="sr-only">'.__('Toggle navigation','detheme').'</span>
      <span class="icon-th-list"></span>
    </button>
  </div>
 <div class="collapse navbar-collapse" id="dt-featured-filter">
	<ul id="featured-filter" data-isotope="portfolios" class="dt-featured-filter nav navbar-nav">
	<li class="active"><a href="#" data-filter="*" class="active">'.__('All Projects','detheme').'</a></li>';

			foreach($categories as $menuObj){

				$navbar.='<li><a href="#" data-filter=".'.$menuObj->slug.'">'.$menuObj->name.'</a></li>';

				$queryargs = array(
		                'post_type' => 'port',
						'no_found_rows' => false,
						'posts_per_page'=>$post_per_page,
						'portcat'=>$menuObj->slug
					);

				$queryargs['post__not_in']=$rowid;
	
				$query = new WP_Query( $queryargs );	
				$max_page=$query->max_num_pages;

				$query->posts=array_filter($query->posts,'filterRow');


				if ( $query->have_posts() ) :

				while ( $query->have_posts() ) : 
				
						$query->the_post();
						
						ob_start();

						get_template_part( 'content', 'portfolio-imagefull');
						$post_portfolios[]=ob_get_contents();
						ob_end_clean();

						
				endwhile;
				
				if($max_page > 1 ):
				
					array_push($navigations,$menuObj->slug);
					endif; 
				endif;

			wp_reset_query();

			}

	$navbar.='</ul></div></nav>';

}

if(count($post_portfolios)):?>

<div class="portfolio">
<div class="container">
<div class="row" >
<?php print $navbar;?>
</div>
</div>
<div class="row" >
	<div id="portfolios" data-type="imagefull" data-col="<?php print $column;?>" class="portfolio-container">
<?php 	if(count($post_portfolios)):
			
			print @implode("",$post_portfolios);
		
		endif;
		?>
	</div>
<?php if(count($navigations) && count($post_portfolios)):?>
	<div class="portfolio-navigation">
<?php

$permalink = (bool)get_option('permalink_structure');


foreach($navigations as $navigation){
				$queryargs = array(
		                'post_type' => 'port',
						'no_found_rows' => false,
						'posts_per_page'=>$post_per_page,
						'portcat'=>$navigation
					);

				$queryargs['post__not_in']=$rowid;
				$query = new WP_Query( $queryargs );		
				$max_page=$query->max_num_pages;
			if($query->have_posts()):

				$nav_link=add_query_arg( 'page',1, get_term_link( $navigation, 'portcat' ));
				$nav_link=add_query_arg( 'in',@implode(',',$rowid), $nav_link);
				$nav_link=add_query_arg( 'posts_per_page',$post_per_page, $nav_link);


			print '<a class="button btn-more more-post '.$navigation.'" href="'.esc_url($nav_link).'">
					'.__('Load More','detheme').'</a>'."\n";
	
				endif;
			}
			wp_reset_query();
			?>
	</div>
<?php endif;?>
</div>

</div>
<?php endif;
?>
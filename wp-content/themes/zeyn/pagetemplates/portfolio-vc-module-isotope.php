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
 * @version 1.1.4
 */

global $detheme_config,$paged;

$navbar="";
$post_portfolios=array();
$column=get_query_var('column');
$select_category=get_query_var('category');
$post_per_page=get_query_var('posts_per_page');
$show_filter=get_query_var('show_portfolio_filter');
$portfolio_num=get_query_var('portfolio_num');



$datatype="imagefull";
if(!$post_per_page)
{
	$post_per_page=3;
}

if(!$portfolio_num)
{
	$portfolio_num=$post_per_page;
}

$post_per_page=$portfolio_num;
$categories_filter=array();



  $args = array(
          'orderby' => 'name',
          'show_count' => 0,
          'pad_counts' => 0,
          'hierarchical' => 0,
          'taxonomy' => 'portcat',
          'title_li' => ''
        );

$queryargs = array(
    'post_type' => 'port',
	'no_found_rows' => false,
	'posts_per_page'=>$post_per_page
);

if($select_category){
   $queryargs['tax_query']=array(
   array(
            'taxonomy' => 'portcat',
            'field' => 'id',
            'terms' =>@explode(',',$select_category)
        )
    );

	}


$query = new WP_Query( $queryargs );	

if ( $query->have_posts() ) :

	while ( $query->have_posts() ) : 
	
			$query->the_post();
			$terms = get_the_terms(get_the_ID(), 'portcat' );

			if($terms && count($terms) && $show_filter=='yes'){
				foreach ($terms as $term_id=>$term) {
					$categories_filter[$term->term_id]='<li><a href="#" data-filter=".'.$term->slug.'">'.$term->name.'</a></li>';
				}

			}
			ob_start();
			get_template_part( 'content', 'portfolio-imagefull');
			$post_portfolios[]=ob_get_contents();
			ob_end_clean();
			
	endwhile;
endif;

wp_reset_query();

if($show_filter=='yes' && count($categories_filter)){


	$navbar='<nav id="featured-work-navbar" class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#dt-featured-filter">
      <span class="sr-only">'.__('Toggle navigation','detheme').'</span>
      <span class="icon-th-list"></span>
    </button>
  </div>
 <div class="collapse navbar-collapse" id="dt-featured-filter">
	<ul id="featured-filter" data-isotope="portfolios" class="dt-featured-filter nav navbar-nav">
	<li class="active"><a href="#" data-filter="*" class="active">'.__('All Projects','detheme').'</a></li>';
	$navbar.=@implode("\n",$categories_filter);
	$navbar.='</ul></div></nav>';


}

if(count($post_portfolios)):?>

<div class="portfolio">
<?php print $navbar;?>
	<div id="portfolios" data-type="<?php print $datatype;?>" data-col="<?php print $column;?>" class="portfolio-container">
<?php 	if(count($post_portfolios)):
			
			print @implode("",$post_portfolios);
		
		endif;
		
		?>
	</div>
</div>
<?php endif;
?>
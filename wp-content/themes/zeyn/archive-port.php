<?php
defined('ABSPATH') or die();
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

global $detheme_config,$paged,$wp_query;
if(!isset($_GET['type'])){

	locate_template('index.php',true);
}
else{

switch ($_GET['type']) {
	case 'text':
		$type='text';
		break;
	case 'imagefull':
		$type='imagefull';
		break;
	case 'imagefixheightfull':
		$type='imagefixheightfull';
		break;
	case 'vcimage':
		$type='vcimage';
		break;
	default:
		$type='image';
		break;
}

if(!isset($_GET['in']))
	$_GET['in']="";

if(!isset($_GET['col']))
	$_GET['col']=3;

switch ($_GET['col']) {
	case 6:	
			$column=6;
		break;
	case 5:	
			$column=5;
		break;
	case 4:	
			$column=4;
		break;
	default:
		$column=3;
		break;
}


if(isset($_GET['posts_per_page'])){
	set_query_var('posts_per_page',$_GET['posts_per_page']);
}
$post_per_page=get_query_var( 'posts_per_page' );
set_query_var('column',$column);

if('imagefixheightfull'==$type || 'vcimage'==$type){

		$paged=get_query_var( 'page' );
		if ( !$paged ){
				$paged = 1;
		}

		$nextpage = intval($paged) + 1;

		get_header();
		?>

		<div class="container">
		<div id="portfolios">

		<?php

						$queryargs = array(
				                'post_type' => 'port',
								'no_found_rows' => false,
								'posts_per_page'=>$post_per_page,
								'paged'=>$paged,
							);

					if(get_query_var('portcat')){
						   $queryargs['tax_query']=array(
						   array(
						            'taxonomy' => 'portcat',
						            'field' => 'slug',
						            'terms' =>@explode(',',get_query_var('portcat'))
						        )
						    );

						}


			
						$query = new WP_Query( $queryargs );		

						$max_page=$query->max_num_pages;
						if ( $query->have_posts() ) :
						while ( $query->have_posts() ) : 
						
								$query->the_post();
								get_template_part( 'content', 'portfolio-'.($type=='vcimage'?"imagefull":'imagefixheightfull'));
								
						endwhile;
						endif;

						$permalink = (bool)get_option('permalink_structure');


		?>
		</div>

		<?php if($nextpage <= $max_page):?>
			<div class="portfolio-navigation">
		<?php
				$nav_link=add_query_arg( 'page',$nextpage, get_post_type_archive_link('port'));
				$nav_link=add_query_arg( 'posts_per_page',$post_per_page, $nav_link);
				$nav_link=add_query_arg( 'type',$type, $nav_link);

				print '<a class="button btn-more more-post" href="'.esc_url($nav_link).'">'.__('Load More','detheme').'</a>'."\n";
	
			?>
			</div>
		<?php endif;?>


		</div>
		<?php
		get_footer();


}else{

		set_query_var('post__not_in',trim($_GET['in']));
		$paged=get_query_var( 'page' );

		$post_not_in=get_query_var('post__not_in');

		if ( !$paged ){
				$paged = 1;
		}

		$nextpage = intval($paged) + 1;

		get_header();
		?>
			<div class="container">
			<div id="portfolios">

		<?php


						$queryargs = array(
				                'post_type' => 'port',
								'no_found_rows' => false,
								'posts_per_page'=>$post_per_page,
								'paged'=>$paged,
								'post__not_in'=>@explode(',',$post_not_in),
		                		'portcat' =>get_query_var( 'portcat' )
							);

			
						$query = new WP_Query( $queryargs );		

						$max_page=$query->max_num_pages;
						if ( $query->have_posts() ) :
						while ( $query->have_posts() ) : 
						
								$query->the_post();
								get_template_part( 'content', 'portfolio-'.$type);
								
						endwhile;
						endif;

						$permalink = (bool)get_option('permalink_structure');


		?>
		</div>

		<?php if($nextpage <= $max_page):?>
			<div class="portfolio-navigation">
		<?php

					$nav_link=add_query_arg( 'page',$nextpage, get_term_link( get_query_var( 'portcat' ), 'portcat' ));
					$nav_link=add_query_arg( 'posts_per_page',$post_per_page, $nav_link);
					$nav_link=add_query_arg( 'in',$post_not_in, $nav_link);
					$nav_link=add_query_arg( 'type',$type, $nav_link);



					print '<a class="button btn-more more-post '.get_query_var( 'portcat' ).'" href="'.esc_url($nav_link).'">
							'.__('Load More','detheme').'</a>'."\n";
			
					?>
			</div>
		<?php endif;?>


		</div>
		<?php
		get_footer();

}

}

?>
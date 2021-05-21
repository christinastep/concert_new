<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post()?>
	<?php 
		$artist_id = get_post_meta(get_the_ID())['artist_id'][0];
		$artist_content = get_post($artist_id);

		$concert_id = get_post_meta(get_the_ID())['concert_id'][0];


		//var_dump( $concert_id);
		//var_dump(get_post( $concert_id ));

		$meta_values = get_post_meta($concert_id, "meta_value" );
		//var_dump( $meta_values );

		//var_dump( get_the_ID());

 ?>

	<?php 

	$cc_arg = array(
		'post_type' => 'cineconcert',
		//'p'=>$concert_id
	);

	$cc_list = new WP_Query( $cc_arg );
	ob_start(); 


	?><p>Cine-Concert: </p><?php
	if ( $cc_list->have_posts() ) {

		while(  $cc_list->have_posts() ) {
 
			 $cc_list->the_post();


			 //var_dump(get_post_meta(get_the_ID() , 'concert_id', true));
			 
			 // Le reste
			 if( get_post_meta( get_the_ID() , 'concert_id' , true) == $concert_id){
				?>
				
				
				<p><?php the_title();	?></p>
				
				<?php
			 }
			 
		}
	}
	//var_dump($cc_list);


	wp_reset_postdata();

	?>


	
		<a href="http://localhost:8888/wordpress-marc/artiste/<?= $artist_content->post_name;?>"><h2><?= get_the_title( $artist_content ) ?></h2></a>


	


	<?php get_template_part( 'template-parts/content/content-single' );

	if ( is_attachment() ) {
		// Parent post navigation.
		the_post_navigation(
			array(
				/* translators: %s: Parent post link. */
				'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone' ), '%title' ),
			)
		);
	}

	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}

	// Previous/next post navigation.
	$twentytwentyone_next = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' );
	$twentytwentyone_prev = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' );

	$twentytwentyone_next_label     = esc_html__( 'Next post', 'twentytwentyone' );
	$twentytwentyone_previous_label = esc_html__( 'Previous post', 'twentytwentyone' );

	the_post_navigation(
		array(
			'next_text' => '<p class="meta-nav">' . $twentytwentyone_next_label . $twentytwentyone_next . '</p><p class="post-title">%title</p>',
			'prev_text' => '<p class="meta-nav">' . $twentytwentyone_prev . $twentytwentyone_previous_label . '</p><p class="post-title">%title</p>',
		)
	);
endwhile; // End of the loop.

get_footer();

<?php get_header(); ?>

<div class="content">

	<?php
	query_posts( $args );
	while ( have_posts() ) : the_post();
	?>
		<div class="posts">
	      <div class="title">
					<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
				</div>

				<div class="image">
					<?php
					$image = get_field('featured_image');
					if( !empty($image) ): ?>
						<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
					<?php endif; ?>
				</div>

				<div class="location">
					<?php
					$taxonomy = 'category';
					$post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
					$separator = ', ';
					if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
					    $term_ids = implode( ',' , $post_terms );
					    $terms = wp_list_categories( array(
					        'title_li' => '',
					        'style'    => 'none',
					        'echo'     => false,
					        'taxonomy' => $taxonomy,
					        'include'  => $term_ids
					    ) );
					    $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
					    echo  $terms;
					}
					?>
				</div>

				<div class="tags">
					<?php echo get_the_tag_list('',', ','');	?>
				</div>

		</div>
	<?php
	endwhile;
	wp_reset_query();
	?>

</div>

<?php get_footer(); ?>

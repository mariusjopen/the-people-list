<?php get_header(); ?>

<div class="title">
	<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
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

<div class="content">
  <?php
  if( have_rows('content') ):

    while ( have_rows('content') ) : the_row();

      if( get_row_layout() == 'text' ):
      ?>

        <div class="group-text">
      	   <p><?php echo get_sub_field('group_text'); ?></p>
        </div>

      <?php
      elseif( get_row_layout() == 'gallery' ):
      ?>

        <div class="group-galerie">
          <?php
          $images = get_sub_field('group_gallery');
          $size = '_768';
          if( $images ):
          ?>
            <ul>
              <?php
              foreach( $images as $image ):
              ?>
                <li>
                  <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                </li>
              <?php
              endforeach;
              ?>
            </ul>
          <?php
          endif;
          ?>
        </div>

      <?php
      elseif( get_row_layout() == 'embed' ):
      ?>

        <div class="group-embed">
          <?php
          $iframe = get_sub_field('group_embed');

          preg_match('/src="(.+?)"/', $iframe, $matches);
          $src = $matches[1];

          $params = array(
            'controls'    => 0,
            'hd'        => 1,
            'autohide'    => 1
          );

          $new_src = add_query_arg($params, $src);
          $iframe = str_replace($src, $new_src, $iframe);
          $attributes = 'frameborder="0"';
          $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

          echo $iframe;
          ?>
        </div>


        <?php
        endif;

      endwhile;

    else :

  endif;
  ?>
</div>

<?php get_footer(); ?>

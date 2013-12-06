<?php
/*
*
*
* Template Name: Home
*
*/

 get_header(); ?>
  <?php echo do_shortcode("[metaslider id=" . get_option('py_sliderid') . "]"); ?>
        <div id="container">
            <div id="content">
 
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
<?php the_content(); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
<?php edit_post_link( __( 'Edit', 'your-theme' ), '<span class="edit-link">', '</span>' ) ?>
                    <?php if(get_option('py_home_gallery_sliderid') != '' ) {
					echo do_shortcode("[metaslider id=" . get_option('py_home_gallery_sliderid') . "]"); 
					}
					?>
					<p>&nbsp;</p>
					</div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
<?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>            
 
            </div><!-- #content -->
			<?php get_sidebar(); ?>
        </div><!-- #container -->
 
<?php get_footer(); ?>
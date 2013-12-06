<?php get_header(); ?>
<?php if (get_option('py_banner') != "") { ?>
 <img width="1903" src="<?php echo get_option('py_banner'); ?>" alt=" " />
 <?php } ?>
        <div id="container">
            <div id="content">
 
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
<?php the_content(); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
<?php edit_post_link( __( 'Edit', 'your-theme' ), '<span class="edit-link">', '</span>' ) ?>
                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->          
<?php //if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>    
	<?php comments_template('', true); ?>        
 
            </div><!-- #content -->
			<?php get_sidebar(); ?>
        </div><!-- #container -->
 
<?php get_footer(); ?>
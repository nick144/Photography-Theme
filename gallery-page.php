<?php
/*
 * Template Name: Gallery
 */
 get_header(); ?>
 
        <div id="container">
            <div id="content">
 
<?php the_post(); ?>

<?php  
 ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
<?php the_content(); ?>


  <?php
$args = array(  
    'numberposts' => -1, // Using -1 loads all posts  
    'orderby' => 'menu_order', // This ensures images are in the order set in the page media manager  
    'order'=> 'ASC',  
    'post_mime_type' => 'image', // Make sure it doesn't pull other resources, like videos  
    'post_parent' => $post->ID, // Important part - ensures the associated images are loaded 
    'post_status' => null, 
    'post_type' => 'attachment'  
);  
  
$images = get_children( $args );  
//print_r ($images);
//exit;

if($images){ ?>
<section class="slider">  

 </section>
    <?php } ?>
<section class="fancybox-slider"> 
<div id="slider" class="fancybox">  

    <?php foreach($images as $image){ ?>  
	<div class="fancy-image">
	<?php $thumbnail = wp_get_attachment_image_src($image->ID); $thumbsrc = $thumbnail[0]; ?>
	<a class="fancybox-thumbs" data-fancybox-group="thumb" href="<?php echo $image->guid; ?>"><img src="<?php echo $thumbsrc; ?>" alt="<?php echo $image->post_title; ?>" title="<?php echo $image->post_title; ?>" /> </a>
</div>
	<p></p>
    <?php } ?>  
	<div class="clear"></div>
</div>  

 <!--
		<h3>Thumbnail helper</h3>

		<a class="fancybox-thumbs" data-fancybox-group="thumb" href="http://ip-208-109-186-112.ip.secureserver.net/rachana/andrewpaulphotography/wp-content/themes/Photography/4_b.jpg"><img src="http://ip-208-109-186-112.ip.secureserver.net/rachana/andrewpaulphotography/wp-content/themes/Photography/4_b.jpg" alt="" /></a>

		<a class="fancybox-thumbs" data-fancybox-group="thumb" href="http://ip-208-109-186-112.ip.secureserver.net/rachana/andrewpaulphotography/wp-content/themes/Photography/3_b.jpg"><img src="http://ip-208-109-186-112.ip.secureserver.net/rachana/andrewpaulphotography/wp-content/themes/Photography/3_b.jpg" alt="" /></a>

		<a class="fancybox-thumbs" data-fancybox-group="thumb" href="http://ip-208-109-186-112.ip.secureserver.net/rachana/andrewpaulphotography/wp-content/themes/Photography/2_b.jpg"><img src="http://ip-208-109-186-112.ip.secureserver.net/rachana/andrewpaulphotography/wp-content/themes/Photography/2_b.jpg" alt="" /></a>

		<a class="fancybox-thumbs" data-fancybox-group="thumb" href="http://ip-208-109-186-112.ip.secureserver.net/rachana/andrewpaulphotography/wp-content/themes/Photography/1_b.jpg"><img src="http://ip-208-109-186-112.ip.secureserver.net/rachana/andrewpaulphotography/wp-content/themes/Photography/1_b.jpg" alt="" /></a> -->
		
	</section>
	
	
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
<?php edit_post_link( __( 'Edit', 'your-theme' ), '<span class="edit-link">', '</span>' ) ?>
                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
<?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>            
 
            </div><!-- #content -->
			<?php get_sidebar(); ?>
        </div><!-- #container -->
		
  
<?php get_footer(); ?>
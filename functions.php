<?php
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'hbd-theme', TEMPLATEPATH . '/languages' );
	
	add_theme_support( 'menus' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable($locale_file) )
	    require_once($locale_file);

	// Get the page number
	function get_page_number() {
	    if ( get_query_var('paged') ) {
	        print ' | ' . __( 'Page ' , 'hbd-theme') . get_query_var('paged');
	    }
	} // end get_page_number

	// Custom callback to list comments in the hbd-theme style
	function custom_comments($comment, $args, $depth) {
	  $GLOBALS['comment'] = $comment;
	    $GLOBALS['comment_depth'] = $depth;
	  ?>
	    <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
	        <div class="comment-author vcard"><img src="<?php echo get_template_directory_uri(); ?>/img/comments-icon.png" alt="comments" />  <strong><em>By <?php commenter_link() ?></em></strong>: <?php echo $comment->comment_content; ?></div>
			<div class="spacer"></div>
	        <!--<div class="comment-meta"><?php //printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'hbd-theme'),
	                  //  get_comment_date(),
	                  //  get_comment_time(),
	                  //  '#comment-' . get_comment_ID() );
	                  //  edit_comment_link(__('Edit', 'hbd-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
						
				-->
	  <?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'hbd-theme') ?>
	          <!-- <div class="comment-content">
	            
	        </div> -->
	        <?php // echo the comment reply link
	            //if($args['type'] == 'all' || get_comment_type() == 'comment') :
	             //   comment_reply_link(array_merge($args, array(
	             //       'reply_text' => __('Reply','hbd-theme'),
	             //       'login_text' => __('Log in to reply.','hbd-theme'),
	             //       'depth' => $depth,
	             //       'before' => '<div class="comment-reply-link">',
	             //       'after' => '</div>'
	              //  )));
	            //endif;
	        ?>
	<?php } // end custom_comments
	
	// Custom callback to list pings
	function custom_pings($comment, $args, $depth) {
	       $GLOBALS['comment'] = $comment;
	        ?>
	            <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
	                <div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'hbd-theme'),
	                        get_comment_author_link(),
	                        get_comment_date(),
	                        get_comment_time() );
	                        edit_comment_link(__('Edit', 'hbd-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
	    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'hbd-theme') ?>
	            <div class="comment-content">
	                <?php comment_text() ?>
	            </div>
	<?php } // end custom_pings
	
	// Produces an avatar image with the hCard-compliant photo class
	function commenter_link() {
	    $commenter = get_comment_author_link();
	    if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
	        $commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	    } else {
	        $commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	    }
	    $avatar_email = get_comment_author_email();
	    $avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
	    echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
	} // end commenter_link
	
	// For category lists on category archives: Returns other categories except the current one (redundant)
	function cats_meow($glue) {
	    $current_cat = single_cat_title( '', false );
	    $separator = "\n";
	    $cats = explode( $separator, get_the_category_list($separator) );
	    foreach ( $cats as $i => $str ) {
	        if ( strstr( $str, ">$current_cat<" ) ) {
	            unset($cats[$i]);
	            break;
	        }
	    }
	    if ( empty($cats) )
	        return false;

	    return trim(join( $glue, $cats ));
	} // end cats_meow
	
	// For tag lists on tag archives: Returns other tags except the current one (redundant)
	function tag_ur_it($glue) {
	    $current_tag = single_tag_title( '', '',  false );
	    $separator = "\n";
	    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	    foreach ( $tags as $i => $str ) {
	        if ( strstr( $str, ">$current_tag<" ) ) {
	            unset($tags[$i]);
	            break;
	        }
	    }
	    if ( empty($tags) )
	        return false;

	    return trim(join( $glue, $tags ));
	} // end tag_ur_it
	
	// Register widgetized areas
	function theme_widgets_init() {
	    // Area 1
	    register_sidebar( array (
	    'name' => 'Primary Widget Area',
	    'id' => 'primary_widget_area',
	    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	    'after_widget' => "</li>",
	    'before_title' => '<h3 class="widget-title">',
	    'after_title' => '</h3>',
	  ) );

	    // Area 2
	    register_sidebar( array (
	    'name' => 'Secondary Widget Area',
	    'id' => 'secondary_widget_area',
	    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	    'after_widget' => "</li>",
	    'before_title' => '<h3 class="widget-title">',
	    'after_title' => '</h3>',
	  ) );
	} // end theme_widgets_init

	add_action( 'init', 'theme_widgets_init' );
	
	$preset_widgets = array (
	    'primary_widget_area'  => array( 'search', 'pages', 'categories', 'archives' ),
	    'secondary_widget_area'  => array( 'links', 'meta' )
	);
	if ( isset( $_GET['activated'] ) ) {
	    update_option( 'sidebars_widgets', $preset_widgets );
	}
	// update_option( 'sidebars_widgets', NULL );
	
	// Check for static widgets in widget-ready areas
	function is_sidebar_active( $index ){
	  global $wp_registered_sidebars;

	  $widgetcolums = wp_get_sidebars_widgets();

	  if ($widgetcolums[$index]) return true;

	    return false;
	} // end is_sidebar_active


/*************** Theme Option *********************/

$themename = "Photography";
$shortname = "py";


$options = array (
 
	array( 
		"name" 		=> $themename." Options",
		"type" 		=> "title"
	),
 
	array( 
		"name" 		=> "Theme Setting",
		"type" 		=> "section"
	),
	
	array( 
		"type" 		=> "open"
	),
 

	
	array( 
		"name" 		=> "Logo URL",
		"desc"		=> "Enter the link to your logo image",
		"id" 		=> $shortname . "_logo",
		"type" 		=> "upload",
		"std" 		=> ""
	),
	
	array( 
		"name" 		=> "Banner Image",
		"desc"		=> "Enter the link for banner image",
		"id" 		=> $shortname . "_banner",
		"type" 		=> "upload",
		"std" 		=> ""
	),
	
	array( 
		"name" 		=> "Custom CSS",
		"desc" 		=> "Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}",
		"id" 		=> $shortname . "_custom_css",
		"type" 		=> "textarea",
		"std" 		=> ""
	),

	array( 
	
		"name" 		=> "Google Analytics UA Code",
		"desc" 		=> "You can paste your Google Analytics UA code here. This will be added right above </head> tag.",
		"id" 		=> $shortname . "_ga_code",
		"type" 		=> "text",
		"std" 		=> ""
	),	
	
	array( 
	
		"name" 		=> "Telephone Number",
		"desc" 		=> "Enter your telephone number here. This will be shown at the top of the page.",
		"id" 		=> $shortname . "_telno",
		"type" 		=> "text",
		"std" 		=> ""
	),
	
	array( 
	
		"name" 		=> "Enter the top Metaslider ID",
		"desc" 		=> "Enter the Meta slider id for homepage top bar",
		"id" 		=> $shortname . "_sliderid",
		"type" 		=> "text",
		"std" 		=> "24"
	),
	
	array( 
	
		"name" 		=> "Enter the Home gallery Metaslider ID",
		"desc" 		=> "Enter the Meta slider id for homepage Gallery Section",
		"id" 		=> $shortname . "_home_gallery_sliderid",
		"type" 		=> "text",
		"std" 		=> "35"
	),
	
	array( 
		"type" 		=> "close"
	),
	
	array( 
		"name" 		=> "Footer & Social Media",
		"type" 		=> "section"
	),
	
	array( 
		"type" 		=> "open"
	),
 
	array (
	
		"name"		=> "Copyrights",
		"des"		=> "Enter the copyright Content",
		"id" 		=> $shortname . "_copyrights",
		"type" 		=> "text",
		"std" 		=> ""
	
	),
	
	array( 
		"name" 		=> "Facebook",
		"desc" 		=> "Enter Link for Facebook",
		"id" 		=> $shortname . "_facebook",
		"type" 		=> "text",
		"std" 		=> ""
	),
	
	array( 
		"name" 		=> "Twitter Link",
		"desc" 		=> "Enter the link for Twitter",
		"id" 		=> $shortname . "_twitter",
		"type" 		=> "text",
		"std" 		=> ""
	),
	
	array( 
		"type" 		=> "close"
	)
 
);


function py_add_admin() {
 
	global $themename, $shortname, $options;
	
	if(isset($_GET['page'])){
	 
		if ($_GET['page'] == basename(__FILE__)) {
		
			if(isset($_REQUEST['action'])){
		 
				if ($_REQUEST['action'] == 'save') {
			 
					foreach ($options as $value) {
						if (isset($value['id'])){
							update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
						}
					}
			 
					foreach ($options as $value) {
						if (isset($value['id'])){						
							if( isset( $_REQUEST[ $value['id'] ] ) ) { 
								update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); 
							} else { 
								delete_option( $value['id'] ); 
							} 
						}
					}
			 
				header("Location: admin.php?page=functions.php&saved=true");
				
				die;
				
			}
		 
			} else if(isset($_REQUEST['action'])){
			
				if('reset' == $_REQUEST['action']) {
		 
					foreach ($options as $value) {
						if (isset($value['id'])){
							delete_option( $value['id'] ); 
						}
					}
				 
					header("Location: admin.php?page=functions.php&reset=true");
					die;
				
				}
		 
			
			}
		}
	}

	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'py_admin');
}


function py_add_init() {

	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("functions", $file_dir."/framework/functions.css", false, "1.0", "all");
	wp_enqueue_script("py_script", $file_dir."/framework/py_script.js", false, "1.0");

}



function py_admin() {
 
	global $themename, $shortname, $options;
	$i=0;
	
	if(isset($_REQUEST['action'])){
	
		if ( $_REQUEST['saved'] ) {
			echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
		}
	}
	
	if(isset($_REQUEST['action'])){
	
		if ( $_REQUEST['reset'] ) {
			echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
		}
	
	}
	 
	?>
	
	<div class="wrap rm_wrap">
	<h2><?php echo $themename; ?> Settings</h2>
	 
	<div class="rm_opts">
	<form method="post">
	<?php foreach ($options as $value) {
	
		switch ( $value['type'] ) {
		 
		case "open":
		?>
		 
		<?php break;
		 
		case "close":
		?>
		 
		</div>
		</div>
		<br />

		 
		<?php break;
		 
		case "title":
		?>
		<p>To easily use the <?php echo $themename;?> theme, you can use the menu below.</p>

		 
		<?php break;
		 
		case 'text':
		?>

		<div class="rm_input rm_text">

			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
		 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
		 
		 </div>
		<?php
		break;
		 
		case 'textarea':
		?>

		<div class="rm_input rm_textarea">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
		 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
		 
		 </div>
		  
		<?php
		break;
		 
		case 'select':
		?>

		<div class="rm_input rm_select">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			
		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
		<?php foreach ($value['options'] as $option) { ?>
				<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
		</select>

			<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
		</div>
		<?php
		break;
		 
		case "checkbox":
		?>

		<div class="rm_input rm_checkbox">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />


			<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
		 </div>
		<?php break; 
		case "section":

		$i++;

		?>

		<div class="rm_section">
		<div class="rm_title"><h3><img src="<?php bloginfo('template_directory')?>/framework/images/trans.png" class="inactive" alt=""><?php echo $value['name']; ?></h3><span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
		</span><div class="clearfix"></div></div>
		<div class="rm_options">

		 
		<?php break;
		case "upload":
?>


<div class="rm_input rm_upload">

<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <input id="<?php echo $value['id']; ?>" type="text" size="36" name="<?php echo $value['id']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
    <input id="<?php echo $value['id']; ?>_button" name="<?php echo $value['id']; ?>" class="upload_image_button" class="button" type="button" value="Upload Image" />
   <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
		
</div>	
<?php
break;
		
		}
	}
	?>
	 
	<input type="hidden" name="action" value="save" />
	</form>
	<form method="post">
	<p class="submit">
	<input name="reset" type="submit" value="Reset" />
	<input type="hidden" name="action" value="reset" />
	</p>
	</form>
	</div> 
 

<?php
}

add_action('admin_init', 'py_add_init');
add_action('admin_menu', 'py_add_admin');


/* function wp_gear_manager_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('jquery');
} */

wp_enqueue_script('jquery');

/* function wp_gear_manager_admin_styles() {
wp_enqueue_style('thickbox');
} */

/* add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
add_action('admin_print_styles', 'wp_gear_manager_admin_styles');	 */

add_action('admin_enqueue_scripts', 'upload_admin_scripts');
 
function upload_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'functions.php') {
        wp_enqueue_media();
        wp_register_script('uploader', get_template_directory_uri() . '/framework/uploader.js', array('jquery'));
        wp_enqueue_script('uploader');
    }
}


add_theme_support( 'post-thumbnails' ); 


?>
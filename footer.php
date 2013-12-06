    </div><!-- #main -->
 
    <div id="footer">
        <div id="colophon">
 
            <div id="site-info">
				<div class="copyright alignleft">
				<?php if(get_option('py_copyrights') != '') { ?>
				&copy; <?php echo get_option('py_copyrights'); ?> | 
				<?php } ?>Designed by: <a href="http://www.taskseveryday.com">Tasks Everyday</a> </div>
				<div class="social alignright">
				<?php if(get_option('py_facebook') != '') { ?>
				<a href="<?php echo get_option('py_facebook'); ?>"><img src="<?php echo site_url(); ?>/wp-content/themes/Photography/img/facebook.jpg" alt="Facebook" /></a>&nbsp;&nbsp;&nbsp;
				<?php } ?>
				<?php if(get_option('py_twitter') != '') { ?>
				<a href="<?php echo get_option('py_twitter'); ?>"><img src="<?php echo site_url(); ?>/wp-content/themes/Photography/img/twitter.jpg" alt="Twitter" /></a>
				<?php } ?>
				</div>
				<div class="clear"></div>
            </div><!-- #site-info -->
 
        </div><!-- #colophon -->
    </div><!-- #footer -->
</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
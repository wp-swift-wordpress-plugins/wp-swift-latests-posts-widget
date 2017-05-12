<?php $widget_id = "widget_" . $args["widget_id"]; ?>
<article class="row widget widget_meta wp-swift-widget <?php echo $widget_id; ?>">
	<?php 
		$id = get_the_ID();
		$posts_per_page = get_field('count', $widget_id);
	    if (function_exists('posts_widget_content')) {
	        posts_widget_content($title=get_field('header', $widget_id), array($id), $post_type=get_field('post_type', $widget_id), $posts_per_page);
	    }  
	  ?>
</article>

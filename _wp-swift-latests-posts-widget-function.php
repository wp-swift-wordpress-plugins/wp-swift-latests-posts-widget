<?php
/*
  Plugin Name:       WP Swift: Latest Posts Widget
  Description:       A widget for displaying posts and custom posts in the sidebar.
  Version:           1.0.0
  Author:            Gary Swift
  License:           GPL-2.0+
  Text Domain:       wp-swift-latests-posts-widget
*/

// Inclide the ACF group
include "_acf-field-group.php";

class WP_Swift_Latest_Posts_Widget extends WP_Widget {
 
    public function __construct() {
     
        parent::__construct(
            'wp_swift_latest_posts_widget',
            __( 'WP Swift: Latest Posts Widget', 'wp-swift-latests-posts-widget' ),
            array(
                'classname'   => 'wp_swift_latest_posts_widget',
                'description' => __( 'A widget for posts and custom posts in the sidebar.', 'wp-swift-latests-posts-widget' )
                )
        );
       
        load_plugin_textdomain( 'wp-swift-latests-posts-widget', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }
 
    /**  
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {    
        include( plugin_dir_path( __FILE__ ) . '_wp-swift-latests-posts-widget.php');
    }
 
  
    /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
    public function update( $new_instance, $old_instance ) {        
        return $instance;
    }
  
    /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
    public function form( $instance ) { 
      //The ACF API will handle this
    }
}
 
/* Register the widget */
add_action( 'widgets_init', function(){
    register_widget( 'WP_Swift_Latest_Posts_Widget' );
});

function posts_widget_content($title='', $post__not_in = array(), $post_type = 'post', $posts_per_page = 2) {
    $args = array( 
        'post_type' => $post_type,
        'posts_per_page' => $posts_per_page, 
        'post__not_in' => $post__not_in,
        'post_status' => 'publish',
    );

    global $wp_query;
    $wp_query = new WP_Query($args);

    if ( have_posts() ) :
        if ($title): ?>
            <div class="solid-subheader aside">
                <div class="row">
                    <div class="columns">
                        <h3><?php echo $title ?></h3>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <div class="row small-up-1 medium-up-1 large-up-1 latest-news-widget"><?php 
        while ( have_posts() ) : the_post();                        
            ?>
            <div class="column column-block">
                <article id="post-<?php the_ID(); ?>">

                    <div class="row">
                        <div class="columns">
                        <?php if (function_exists('get_featured_image')): ?>
                            <?php $image = get_featured_image(get_the_ID()); ?>
                            <?php if ($image): ?>
                                <a href="<?php the_permalink() ?>"><img class="thumbnail aside" src="<?php echo $image['sizes']['thumbnail']; ?>" title="<?php echo get_the_title(); ?>"></a>   
                            <?php endif ?>
                            
                        <?php endif ?>
                    
                            <h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>

                            <div class="entry-content">
                                <?php  the_excerpt(); ?>   
                            </div> 

                        </div>
                    </div>                

                </article>
            </div>
            <?php 
        endwhile; 
        ?></div><?php
    endif; // End have_posts() check.
}
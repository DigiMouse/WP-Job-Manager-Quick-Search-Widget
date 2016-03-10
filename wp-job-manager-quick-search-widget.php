<?php
/**
 * Plugin Name: WP Job Manager - Quick Search Widget
 * Plugin URI:  https://github.com
 * Description: Lets you add a search form as a widget
 * Author:      RokkitPress
 * Author URI:  http://rokkitpress.com
 * Version:     1.0
 * Text Domain: wp-job-manager-quick-search-widget
 */

class WP_Job_Manager_Filters_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'wp_job_manager_filters_widget',

        // Widget name will appear in UI
        __('WP JM: Search Filters', 'wp_job_manager_filters_widget_domain'),

        // Widget description
        array( 'description' => __( 'Adds an jobs search filters to the sidebar', 'wp_job_manager_filters_widget_domain' ), )
        );
    } // Close Constructor

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );
        $url = apply_filters( 'widget_title', $instance['url'] );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if ( ! empty( $title ) )

        echo $args['before_title'] . $title . $args['after_title'];

        // Echo filters
            ?>
            <form method="GET" action="<?php echo $url; ?>" class="wpjm-qsf-wrapper">
                <p>
                    <label for="keywords" style="display:block;">Keywords</label>
                    <input type="text" id="search_keywords" name="search_keywords" class="wpjm-qsf-field" style="width: 100%;" placeholder="e.g. Sales Administrator"/>
                </p>
                <p>
                    <label for="keywords" style="display:block;">Location</label>
                    <input type="text" id="search_location" name="search_location" class="wpjm-qsf-field" style="width: 100%;" placeholder="e.g. West Yorkshire"/>
                </p>
                <p>
                    <label for="search_category" style="display:block;">Category</label>
                    <select id="search_category" name="search_category" class="wpjm-qsf-field" style="width: 100%;">
                    <?php foreach ( get_job_listing_categories() as $cat ) : ?>
                        <option value="<?php echo esc_attr( $cat->term_id ); ?>"><?php echo esc_html( $cat->name ); ?></option>
                    <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <input type="submit" value="Search" />
                </p>
            </form>
            <?php

        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = __( 'New title', 'wp_job_manager_filters_widget_domain' );
        }

        if ( isset( $instance[ 'url' ] ) ) {
            $url = $instance[ 'url' ];
        } else {
            $url = __( 'URL', 'wp_job_manager_filters_widget_domain' );
        }

    // Widget admin form
    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL to page with [Jobs] Shortcode:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
    </p>
    <?php
    }

} // Class WP_Job_Manager_Apply_Button_Widget ends here

// Register and load the widget
function wp_job_manager_filters_widget_load_widget() {
    register_widget( 'WP_Job_Manager_Filters_Widget' );
}
add_action( 'widgets_init', 'wp_job_manager_filters_widget_load_widget' );
/*----------------------------------------------------------------------------------------------*/

/**
 * enqueue form styles
 */
function wp_job_manager_filters_widget_styles() {
    wp_enqueue_style( 'wp-job-manager-filter-widget-styles', plugins_url('/form.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'wp_job_manager_filters_widget_styles' );

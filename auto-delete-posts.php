<?php
/**
 * Plugin Name: WP delete old posts every 6 months
 * Text Domain: autodeleteposts
 * Author:      Muhammad Farhan Khan
 * Author URI:  http://emaksolution.com
 * Description: Deletes all posts older than 6 months every 6 months
 * Version: 1.0
 */

function delete_old_posts() {
    // WP_Query arguments
    // Put your own period here
    $args = array (
        'date_query' => array(
            array(
                'before' => '6 months ago',
            ),
        ),
        'post_type' => 'post',
    );
    
    // The Query
    $query = new WP_Query( $args );
    
    // The Loop
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            wp_delete_post( get_the_ID(), true );
        }
    }
    
    // Restore original Post Data
    wp_reset_postdata();
}

// Schedule event
// Set your own schedule here
wp_schedule_event( time(), '6months', 'delete_old_posts' );

// Hook into that event
add_action( 'delete_old_posts', 'delete_old_posts' );

<?php

// Add Custom Post Types Hardware
add_action( 'init', 'create_hardware_post_type' );

function create_hardware_post_type() {
    register_post_type('hardware', array(
        'labels' => array(
            'name' => __('Hardware'),
            'singular_name' => _x('Hardware','mdr-athena'),
            'add_new' => __('Add New Post', 'mdr-athena'),
            'add_new_item' => __('Add New Post', 'mdr-athena'),
            'edit_item' => __('Edit Hardware', 'mdr-athena'),
            'new_item' => __('New Hardware', 'mdr-athena'),
            'view_item' => __('View Hardware', 'mdr-athena'),
            'search_items' => __('Search Hardware', 'mdr-athena'),
            'not_found' =>  __('No hardware found', 'mdr-athena'),
            'not_found_in_trash' => __('No hardware found in Trash', 'mdr-athena')
        ),
        'description' => __('Hardware Posts', 'mdr-athena'),
        'public' => true,
        'has_archive' => true,
        'capability_type' => 'page',
        'hierarchical' => true,
        'menu_position' => 5, // Just below Post
        'supports' => array('title', 'editor', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes'),
        'feed' => true,
    ));
}

/* Flush rewrite rules for custom post types. */
add_action( 'load-themes.php', 'athena_rewrite_rules' );

/* Flush your rewrite rules */
function athena_rewrite_rules() {
    global $pagenow;

    if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        flush_rewrite_rules();
}

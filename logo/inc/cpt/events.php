<?php
// Register Custom Post Type Events
function custom_register_cpt_events()
{
    // Events CPT
    $events_labels = array(
        'name'               => _x('Events', 'post type general name', 'logo'),
        'singular_name'      => _x('Event', 'post type singular name', 'logo'),
        'menu_name'          => _x('Events', 'admin menu', 'logo'),
        'name_admin_bar'     => _x('Event', 'add new on admin bar', 'logo'),
        'add_new'            => _x('Add New', 'event', 'logo'),
        'add_new_item'       => __('Add New Event', 'logo'),
        'new_item'           => __('New Event', 'logo'),
        'edit_item'          => __('Edit Event', 'logo'),
        'view_item'          => __('View Event', 'logo'),
        'all_items'          => __('All Events', 'logo'),
        'search_items'       => __('Search Events', 'logo'),
        'parent_item_colon'  => __('Parent Events:', 'logo'),
        'not_found'          => __('No events found.', 'logo'),
        'not_found_in_trash' => __('No events found in Trash.', 'logo')
    );

    $events_args = array(
        'labels'             => $events_labels,
        'public'             => true,
        'rewrite'            => array('slug' => 'events'),
        'has_archive'        => true,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
        'taxonomies'         => array('category', 'post_tag'),
    );

    register_post_type('event', $events_args);
}
add_action('init', 'custom_register_cpt_events');

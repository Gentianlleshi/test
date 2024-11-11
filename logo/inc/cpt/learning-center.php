<?php
// Register Custom Post Type learning center
function custom_register_cpt_learning_center()
{
    // Learning Center CPT
    $learning_labels = array(
        'name'               => _x('Learning Center', 'post type general name', 'logo'),
        'singular_name'      => _x('Learning Center', 'post type singular name', 'logo'),
        'singular_name'      => _x('Learning Center', 'post type singular name', 'logo'),
        'menu_name'          => _x('Learning Center', 'admin menu', 'logo'),
        'name_admin_bar'     => _x('Learning Center', 'add new on admin bar', 'logo'),
        'add_new'            => _x('Add New', 'learning center', 'logo'),
        'add_new_item'       => __('Add New Learning Center', 'logo'),
        'new_item'           => __('New Learning Center', 'logo'),
        'edit_item'          => __('Edit Learning Center', 'logo'),
        'view_item'          => __('View Learning Center', 'logo'),
        'all_items'          => __('All Learning Center', 'logo'),
        'search_items'       => __('Search Learning Center', 'logo'),
        'parent_item_colon'  => __('Parent Learning Center:', 'logo'),
        'not_found'          => __('No learning center found.', 'logo'),
        'not_found_in_trash' => __('No learning center found in Trash.', 'logo')
    );

    $learning_args = array(
        'labels'             => $learning_labels,
        'public'             => true,
        'rewrite'            => array('slug' => 'learning-center'),
        'has_archive'        => true,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
        'taxonomies'         => array('category', 'post_tag'),
    );

    register_post_type('learning_center', $learning_args);
}
add_action('init', 'custom_register_cpt_learning_center');

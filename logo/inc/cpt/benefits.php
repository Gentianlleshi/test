<?php
// Register Custom Post Type Benefits
function custom_register_cpt_benefits()
{
    // Benefits CPT (without single post view)
    $benefits_labels = array(
        'name'               => _x('Benefits', 'post type general name', 'logo'),
        'singular_name'      => _x('Benefit', 'post type singular name', 'logo'),
        'menu_name'          => _x('Benefits', 'admin menu', 'logo'),
        'name_admin_bar'     => _x('Event', 'add new on admin bar', 'logo'),
        'add_new'            => _x('Add New', 'Benefit', 'logo'),
        'add_new_item'       => __('Add New Benefit', 'logo'),
        'new_item'           => __('New Benefit', 'logo'),
        'edit_item'          => __('Edit Benefit', 'logo'),
        'view_item'          => __('View Benefit', 'logo'),
        'all_items'          => __('All Benefits', 'logo'),
        'search_items'       => __('Search Benefits', 'logo'),
        'parent_item_colon'  => __('Parent Benefits:', 'logo'),
        'not_found'          => __('No benefit found.', 'logo'),
        'not_found_in_trash' => __('No benefit found in Trash.', 'logo')
    );

    $benefits_args = array(
        'labels'             => $benefits_labels,
        'public'             => true,
        'rewrite'            => array('slug' => 'benefits'),
        'has_archive'        => false,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
        'publicly_queryable' => false,
        'taxonomies'         => array('category', 'post_tag'),
    );
    register_post_type('benefit', $benefits_args);
}
add_action('init', 'custom_register_cpt_benefits');

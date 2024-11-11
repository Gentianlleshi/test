<?php
// Theme setup
function custom_theme_setup()
{
    // Add support for title tag
    add_theme_support('title-tag');

    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Register navigation menu
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'logo'),
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');


// enqueue scripts and styles
function logo_enqueue_scripts()
{
    wp_enqueue_script('logo-script', get_template_directory_uri() . '/dist/script.js', array('jquery'), '1.0', true);
    wp_enqueue_style('logo-style', get_template_directory_uri() . '/dist/style.css');

    // Get the ID of the "Uncategorized" category
    $uncategorized_id = get_cat_ID('Uncategorized');

    // Fetch all categories for the 'benefit' post type, excluding 'Uncategorized'
    $categories = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => true,
        'exclude' => array($uncategorized_id),
    ));

    // Determine the initial category slug (the first category)
    $initial_category_slug = !empty($categories) ? $categories[0]->slug : '';

    wp_localize_script('logo-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'initial_category' => $initial_category_slug,
    ));
}
add_action('wp_enqueue_scripts', 'logo_enqueue_scripts');



// Load CPTs
require_once get_template_directory() . '/inc/cpt/events.php';
require_once get_template_directory() . '/inc/cpt/learning-center.php';
require_once get_template_directory() . '/inc/cpt/benefits.php';
require_once get_template_directory() . '/inc/blocks/custom-blocks.php';


// Load Custom Walker
require_once get_template_directory() . '/inc/walkers/custom-walker-nav-menu.php';






function ajax_filter_benefits()
{
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $inactive_tags = isset($_POST['inactive_tags']) ? array_map('sanitize_text_field', $_POST['inactive_tags']) : array();
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type'      => 'benefit',
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $page,
    );

    $tax_query = array('relation' => 'AND');

    // Category Filtering
    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $category,
            'operator' => 'IN',
        );
    }

    // Exclude Posts with Unchecked Tags
    if (!empty($inactive_tags)) {
        $tax_query[] = array(
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => $inactive_tags,
            'operator' => 'NOT IN',
        );
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) : $query->the_post();
?>
            <div class="benefit-item">
                <div class="wrapper">
                    <div class="benefit-content">
                        <?php the_content(); ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <?php the_category(); ?>
                    <?php echo get_the_tag_list('<div class="tags"> ', ', ', '</div>'); ?>
                </div>
            </div>
<?php
        endwhile;
        $output = ob_get_clean();
        echo $output;
    } else {
        if ($page == 1) {
            echo '<p>No benefits found matching your criteria.</p>';
        }
        // Do not output anything if loading more and no posts are found
    }

    wp_reset_postdata();
    wp_die();
}




// Register AJAX actions for logged-in and non-logged-in users
add_action('wp_ajax_filter_benefits', 'ajax_filter_benefits');
add_action('wp_ajax_nopriv_filter_benefits', 'ajax_filter_benefits');

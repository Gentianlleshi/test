<?php
/*
Template Name: Product
*/


get_header();
?>


<main id="main">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>
    <div class="benefits container">
        <?php
        // Fetch all categories for the 'benefit' post type
        $categories = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => true,
        ));

        // Fetch all tags for the 'benefit' post type
        $tags = get_terms(array(
            'taxonomy' => 'post_tag',
            'hide_empty' => true,
        ));
        ?>

        <div class="benefits-filter-section">
            <h2>Some H2 title </h2>

            <!-- Category Filter (Tabs) -->
            <div class="benefits-categories">
                <?php
                $first_category = true;
                foreach ($categories as $category) : ?>
                    <button class="benefits-category-tab <?php echo $first_category ? 'active' : ''; ?>" data-category="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </button>
                <?php
                    $first_category = false;
                endforeach; ?>
            </div>

            <!-- Tag Filter (Checkboxes) -->
            <div class="benefits-tags" style="opacity: 0;">
                <?php foreach ($tags as $tag) : ?>
                    <label>
                        <input type="checkbox" class="benefits-tag-filter" value="<?php echo esc_attr($tag->slug); ?>" checked>
                        <?php echo esc_html($tag->name); ?>
                    </label>
                <?php endforeach; ?>
            </div>



            <!-- Results Container -->
            <div id="benefits-results">
                <?php
                // Initial query 
                $benefits_query = new WP_Query(array(
                    'post_type' => 'benefit',
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ));

                if ($benefits_query->have_posts()) :
                    while ($benefits_query->have_posts()) : $benefits_query->the_post();
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
                else :
                    echo '<p>No benefits found.</p>';
                endif;

                wp_reset_postdata();
                ?>
            </div>
            <?php
            // Check if there are more posts to load
            $total_posts = $benefits_query->found_posts;
            // console.log($total_posts);
            if ($total_posts > 6) :
            ?>
                <button id="load-more-btn">Load More</button>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php
get_footer();
?>
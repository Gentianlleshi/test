<?php
// Custom Walker for the main navigation menu specificaly to modify the "Resources" menu item html structure
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu
{
    private $resources_item_id = 0;
    private $collecting_resources_items = false;
    private $resources_items = [];
    private $menu_items_by_id = [];

    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        // Map items by their ID for easy lookup
        $this->menu_items_by_id[$item->ID] = $item;

        // Check if the current item is the "Resources" menu item
        if ($depth == 0 && $item->title == 'Resources') {
            $this->resources_item_id = $item->ID;
            $this->collecting_resources_items = true;

            // Output the "Resources" menu item
            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $output .= '<li' . $class_names . '>';
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
        } elseif ($this->collecting_resources_items && $this->is_descendant_of_resources($item)) {
            // Collect submenu items under "Resources"
            $this->resources_items[] = $item;
        } else {
            // Output other menu items normally
            parent::start_el($output, $item, $depth, $args, $id);
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = [])
    {
        if ($depth == 0 && $item->ID == $this->resources_item_id) {
            // Output the custom submenu structure for "Resources"
            $output .= '<ul class="sub-menu resorces">';

            // Get the direct children of "Resources"
            $direct_children = array_filter($this->resources_items, function ($submenu_item) {
                return $submenu_item->menu_item_parent == $this->resources_item_id;
            });

            $total_items = count($direct_children);

            if ($total_items > 0) {
                // Decide where to split
                $split_index = 2;
                $item_index = 0;

                // Initialize flags to track whether spans are open
                $left_side_open = false;
                $right_side_open = false;

                foreach ($direct_children as $submenu_item) {
                    if ($item_index == 0 && !$left_side_open) {
                        // Open left-side span
                        $output .= '<span class="left-side">';
                        $left_side_open = true;
                    }

                    if ($item_index == $split_index) {
                        // Close left-side span
                        if ($left_side_open) {
                            $output .= '</span>';
                            $left_side_open = false;
                        }
                        // Open right-side span if there are more items
                        if ($item_index < $total_items && !$right_side_open) {
                            $output .= '<span class="right-side">';
                            $right_side_open = true;
                        }
                    }

                    $this->output_submenu_item($output, $submenu_item, $args);
                    $item_index++;
                }

                // Close any open spans
                if ($left_side_open) {
                    $output .= '</span>';
                }

                if ($right_side_open) {
                    $output .= '</span><span class="bottom-side">
                <div class="left">
                    <h4>Ready to get started?</h4>
                    <p>See how our application works, how easy it is</p>
                </div>
                <div class="right"><a href="#_">Watch demo</a></div< /span>';
                }
            }

            $output .= '</ul>';

            // Close the "Resources" menu item
            $output .= '</li>';

            // Reset variables
            $this->collecting_resources_items = false;
            $this->resources_items = [];
        } elseif (!$this->collecting_resources_items) {
            // Output end tag for other items
            parent::end_el($output, $item, $depth, $args);
        }
    }

    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        if (!$this->collecting_resources_items) {
            parent::start_lvl($output, $depth, $args);
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = [])
    {
        if (!$this->collecting_resources_items) {
            parent::end_lvl($output, $depth, $args);
        }
    }

    private function is_descendant_of_resources($item)
    {
        $parent_id = $item->menu_item_parent;
        while ($parent_id) {
            if ($parent_id == $this->resources_item_id) {
                return true;
            }
            if (isset($this->menu_items_by_id[$parent_id])) {
                $parent_id = $this->menu_items_by_id[$parent_id]->menu_item_parent;
            } else {
                break;
            }
        }
        return false;
    }

    private function output_submenu_item(&$output, $item, $args, $depth = 1)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';
        $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';

        // Check if the item is an "event" post type
        if ($item->object == 'event' && $depth == 2) {
            // Retrieve the post content
            $post_content = get_post_field('post_content', $item->object_id);
            $post_content = apply_filters('the_content', $post_content);
            $post_content = str_replace(']]>', ']]&gt;', $post_content);

            // Output the post content
            $output .= '<div class="event-content">' . $post_content . '</div>';
        }

        // Get children of this item
        $child_items = $this->get_child_items($item->ID);

        if (!empty($child_items)) {
            $output .= '<ul class="sub-menu">';
            foreach ($child_items as $child_item) {
                $this->output_submenu_item($output, $child_item, $args, $depth + 1);
            }
            $output .= '</ul>';
        }

        $output .= '</li>';
    }

    private function get_child_items($parent_id)
    {
        $child_items = [];
        foreach ($this->resources_items as $item) {
            if ($item->menu_item_parent == $parent_id) {
                $child_items[] = $item;
            }
        }
        return $child_items;
    }
}

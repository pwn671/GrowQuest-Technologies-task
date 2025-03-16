<?php
/**
 * Plugin Name: User Tags
 * Description: Adds a "User Tags" taxonomy for categorizing users.
 * Version: 1.0.3
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; 
}


function ut_register_user_tags_taxonomy() {
    $args = [
        'public'       => false,
        'labels'       => [
            'name'          => __('User Tags'),
            'singular_name' => __('User Tag'),
            'menu_name'     => __('User Tags'),
        ],
        'show_ui'      => true,
        'show_tagcloud' => false,
        'hierarchical' => false,
        'show_admin_column' => true,
        'meta_box_cb'  => false, 
    ];
    register_taxonomy('user_tags', 'user', $args);
}
add_action('init', 'ut_register_user_tags_taxonomy');


function ut_add_user_tags_metabox($user) {
    $terms = get_terms(['taxonomy' => 'user_tags', 'hide_empty' => false]);
    $user_tags = wp_get_object_terms($user->ID, 'user_tags', ['fields' => 'ids']);
    ?>
    <h2><?php _e('User Tags'); ?></h2>
    <table class="form-table">
        <tr>
            <th><label for="user_tags"><?php _e('Select Tags'); ?></label></th>
            <td>
                <select name="user_tags[]" id="user_tags" multiple="multiple" class="user-tags-dropdown">
                    <?php foreach ($terms as $term) : ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>" <?php selected(in_array($term->term_id, $user_tags)); ?>>
                            <?php echo esc_html($term->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'ut_add_user_tags_metabox');
add_action('edit_user_profile', 'ut_add_user_tags_metabox');


function ut_save_user_tags($user_id) {
    if (isset($_POST['user_tags'])) {
        $tags = array_map('intval', $_POST['user_tags']);
        wp_set_object_terms($user_id, $tags, 'user_tags', false);
    }
}
add_action('personal_options_update', 'ut_save_user_tags');
add_action('edit_user_profile_update', 'ut_save_user_tags');


function ut_add_user_tags_admin_menu() {
    add_users_page(__('User Tags'), __('User Tags'), 'manage_categories', 'edit-tags.php?taxonomy=user_tags');
}
add_action('admin_menu', 'ut_add_user_tags_admin_menu');


function ut_add_user_tags_filter_top($which) {
    if ($which === 'bottom') {
        return; 
    }

    $tags = get_terms(['taxonomy' => 'user_tags', 'hide_empty' => false]);
    $selected = isset($_GET['user_tags_filter']) ? sanitize_text_field($_GET['user_tags_filter']) : '';
    ?>
    <label for="user_tags_filter" class="screen-reader-text">Filter by User Tags</label>
    <select name="user_tags_filter" id="user_tags_filter" style="float:unset;">
        <option value=""><?php _e('Filter by User Tags'); ?></option>
        <?php foreach ($tags as $tag) : ?>
            <option value="<?php echo esc_attr($tag->term_id); ?>" <?php selected($selected, $tag->term_id); ?>>
                <?php echo esc_html($tag->name); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="submit" class="button" value="Filter">
    <?php
}
add_action('manage_users_extra_tablenav', 'ut_add_user_tags_filter_top');


function ut_filter_users_by_tag($query) {
    if (is_admin() && isset($_GET['user_tags_filter']) && !empty($_GET['user_tags_filter'])) {
        $tag_id = intval($_GET['user_tags_filter']);
        if ($tag_id) {
            $user_ids = get_objects_in_term($tag_id, 'user_tags');
            if (!empty($user_ids)) {
                $query->query_vars['include'] = $user_ids;
            } else {
                $query->query_vars['include'] = [0];
            }
        }
    }
}
add_filter('pre_get_users', 'ut_filter_users_by_tag');


function ut_enqueue_scripts($hook) {
    if ($hook === 'profile.php' || $hook === 'user-edit.php') {
        wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['jquery'], null, true);
        wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
        wp_add_inline_script('select2', 'jQuery(document).ready(function($){ $(".user-tags-dropdown").select2(); });');
    }
}
add_action('admin_enqueue_scripts', 'ut_enqueue_scripts');

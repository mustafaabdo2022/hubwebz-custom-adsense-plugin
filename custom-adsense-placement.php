<?php
/*
Plugin Name: HubWebz Custom AdSense Placement
Description: Manage Google AdSense code placement through WordPress admin panel.
Version: 1.0
Author: Mustafa
*/

// Add a menu item to the admin panel
function hubwebz_custom_adsense_placement_menu() {
    add_menu_page(
        'AdSense Placement',
        'AdSense Placement',
        'manage_options',
        'hubwebz-custom-adsense-placement',
        'hubwebz_custom_adsense_placement_page'
    );
}
add_action('admin_menu', 'hubwebz_custom_adsense_placement_menu');

// Settings page content
function hubwebz_custom_adsense_placement_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Save settings if form is submitted
    if (isset($_POST['save_adsense_placement'])) {
        update_option('hubwebz_custom_adsense_placement', sanitize_text_field($_POST['adsense_placement']));
        update_option('hubwebz_custom_adsense_code', wp_kses_post($_POST['adsense_code']));
        echo '<div class="updated"><p>AdSense placement and code saved successfully!</p></div>';
    }

    // Retrieve the current AdSense placement and code from options
    $current_adsense_placement = get_option('hubwebz_custom_adsense_placement', '');
    $current_adsense_code = get_option('hubwebz_custom_adsense_code', '');

    // Display the settings form
    ?>
<div class="wrap">
    <h2>AdSense Placement Settings</h2>
    <form method="post" action="">
        <label for="adsense_placement">AdSense Placement:</label><br>
        <select name="adsense_placement">
            <option value="top" <?php selected($current_adsense_placement, 'top'); ?>>Top of the article</option>
            <option value="below_title" <?php selected($current_adsense_placement, 'below_title'); ?>>Below the title
            </option>
            <option value="after_featured_image" <?php selected($current_adsense_placement, 'after_featured_image'); ?>>
                After the featured image</option>
            <option value="after_second_paragraph"
                <?php selected($current_adsense_placement, 'after_second_paragraph'); ?>>After the second paragraph
            </option>
            <option value="middle" <?php selected($current_adsense_placement, 'middle'); ?>>Middle of the article
            </option>
            <option value="bottom" <?php selected($current_adsense_placement, 'bottom'); ?>>Bottom of the article
            </option>
            <option value="after_author_box" <?php selected($current_adsense_placement, 'after_author_box'); ?>>After
                the author box</option>
        </select><br><br>

        <label for="adsense_code">AdSense Code:</label><br>
        <textarea name="adsense_code" rows="6"
            cols="60"><?php echo esc_textarea($current_adsense_code); ?></textarea><br><br>

        <input type="submit" name="save_adsense_placement" class="button-primary" value="Save Placement and Code">
    </form>
</div>
<?php
}

// Enqueue custom CSS and JavaScript
function hubwebz_custom_adsense_styles_scripts() {
    wp_enqueue_style('hubwebz-custom-adsense-styles', plugin_dir_url(__FILE__) . 'css/custom-adsense-styles.css');
    wp_enqueue_script('hubwebz-custom-adsense-scripts', plugin_dir_url(__FILE__) . 'js/custom-adsense-scripts.js', array('jquery'), '', true);

    // Pass the AdSense placement to JavaScript
    wp_localize_script('hubwebz-custom-adsense-scripts', 'adsensePlacement', array('placement' => get_option('hubwebz_custom_adsense_placement', '')));
}
add_action('wp_enqueue_scripts', 'hubwebz_custom_adsense_styles_scripts');

// Display AdSense code based on placement
function hubwebz_display_adsense_code() {
    $adsense_placement = get_option('hubwebz_custom_adsense_placement', '');
    $adsense_code = get_option('hubwebz_custom_adsense_code', '');

    if (!empty($adsense_placement) && !empty($adsense_code)) {
        echo '<div class="hubwebz-custom-adsense-code-wrapper">';
        echo '<div id="hubwebz-custom-adsense-code">' . $adsense_code . '</div>';
        echo '</div>';
    }
}
add_action('wp_footer', 'hubwebz_display_adsense_code');
?>
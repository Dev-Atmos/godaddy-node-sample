<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://devatmos.com
 * @since      1.0.0
 *
 * @package    Elementor_Form_Finder
 * @subpackage Elementor_Form_Finder/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1>Elementor Form Usage Report</h1>
    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Direct Form</th>
                <th>Template Form</th>
                <th>Templates Used</th>
                <th>Link</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pages = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'numberposts' => -1]);

            foreach ($pages as $page) {
                $direct = Elementor_Form_Finder_Detector::has_direct_form($page->ID);
                $template_ids = Elementor_Form_Finder_Detector::get_template_ids_used($page->ID);
                $template_forms = [];
                foreach ($template_ids as $tid) {
                    if (Elementor_Form_Finder_Detector::template_has_form($tid)) {
                        $template_forms[] = get_the_title($tid);
                    }
                }
                ?>
                <tr>
                    <td><?php echo esc_html($page->post_title); ?></td>
                    <td><?php echo $direct ? '✅' : '❌'; ?></td>
                    <td><?php echo !empty($template_forms) ? '✅' : '❌'; ?></td>
                    <td><?php echo implode(', ', array_map('esc_html', $template_forms)); ?></td>
                    <td><a href="<?php echo esc_url(get_permalink($page->ID)); ?>" target="_blank">View</a></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

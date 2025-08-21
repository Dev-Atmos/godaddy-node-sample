<?php
/*
Plugin Name: Gravity Forms Full Detector
Description: Comprehensive scanner to detect Gravity Forms usage across your WordPress site.
Version: 1.0
Author: Your Name
*/

add_action('admin_menu', 'gffd_add_admin_menu');

function gffd_add_admin_menu() {
    add_menu_page('GF Full Detector', 'GF Detector', 'manage_options', 'gf-full-detector', 'gffd_admin_page');
}

function gffd_admin_page() {
    echo '<div class="wrap"><h1>Gravity Forms Full Detector</h1>';
    echo '<p>This plugin scans your site for Gravity Forms usage across plugins, themes, content, and widgets.</p>';
    
    echo '<h2>🔍 Scan Summary</h2><ul>';

    $gf_active = class_exists('GFForms');
    echo '<li><strong>Gravity Forms Plugin Active:</strong> ' . ($gf_active ? '✅ Yes' : '❌ No') . '</li>';

    $gf_shortcode = gffd_check_shortcode_usage();
    echo '<li><strong>Shortcode Usage in Posts/Pages:</strong> ' . ($gf_shortcode ? '✅ Found' : '❌ Not Found') . '</li>';

    $gf_widget_shortcode = gffd_check_widget_shortcode();
    echo '<li><strong>Shortcode Usage in Widgets:</strong> ' . ($gf_widget_shortcode ? '✅ Found' : '❌ Not Found') . '</li>';

    $gf_theme_function = gffd_check_theme_function_usage();
    echo '<li><strong>gravity_form() Function in Theme Files:</strong> ' . ($gf_theme_function ? '✅ Found' : '❌ Not Found') . '</li>';

    $gf_theme_shortcode = gffd_check_theme_shortcode_usage();
    echo '<li><strong>do_shortcode("[gravityform") in Theme Files:</strong> ' . ($gf_theme_shortcode ? '✅ Found' : '❌ Not Found') . '</li>';

    $gf_script = wp_script_is('gform_gravityforms', 'enqueued');
    echo '<li><strong>Gravity Forms Scripts Enqueued:</strong> ' . ($gf_script ? '✅ Yes' : '❌ No') . '</li>';

    global $wpdb;
    $entry_table = $wpdb->prefix . 'gf_entry';
    $entry_exists = $wpdb->get_var("SHOW TABLES LIKE '$entry_table'") === $entry_table;
    echo '<li><strong>Gravity Forms Entries Table:</strong> ' . ($entry_exists ? '✅ Exists' : '❌ Not Found') . '</li>';

    echo '</ul>';

    $pages_with_forms = gffd_list_pages_with_gravity_forms();
    echo '<h2>📄 Pages/Posts with Gravity Forms</h2>';
    if (!empty($pages_with_forms)) {
        echo '<ul>';
        foreach ($pages_with_forms as $page) {
            echo '<li><strong>' . esc_html($page['title']) . '</strong> (' . esc_html($page['type']) . ', ' . esc_html($page['status']) . ') - <a href="' . esc_url($page['url']) . '" target="_blank">View</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No Gravity Forms found in content.</p>';
    }

    echo '</div>';
}

function gffd_check_shortcode_usage() {
    $post_types = get_post_types(['public' => true], 'names');
    $posts = get_posts([
        'post_type' => $post_types,
        'post_status' => ['publish', 'draft', 'private', 'future'],
        'numberposts' => -1
    ]);

    foreach ($posts as $post) {
        if (has_shortcode($post->post_content, 'gravityform') || strpos($post->post_content, '[gravityform') !== false) {
            return true;
        }
    }
    return false;
}

function gffd_check_widget_shortcode() {
    $sidebars_widgets = wp_get_sidebars_widgets();
    foreach ($sidebars_widgets as $widgets) {
        if (is_array($widgets)) {
            foreach ($widgets as $widget_id) {
                $widget = get_option("widget_" . preg_replace('/-\d+$/', '', $widget_id));
                if (is_array($widget)) {
                    foreach ($widget as $instance) {
                        if (is_array($instance) && isset($instance['text']) && strpos($instance['text'], '[gravityform') !== false) {
                            return true;
                        }
                    }
                }
            }
        }
    }
    return false;
}

function gffd_check_theme_function_usage() {
    $theme_dir = get_template_directory();
    $php_files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($theme_dir));
    foreach ($php_files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $contents = file_get_contents($file);
            if (strpos($contents, 'gravity_form(') !== false) {
                return true;
            }
        }
    }
    return false;
}

function gffd_check_theme_shortcode_usage() {
    $theme_dir = get_template_directory();
    $php_files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($theme_dir));
    foreach ($php_files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $contents = file_get_contents($file);
            if (strpos($contents, "do_shortcode('[gravityform") !== false) {
                return true;
            }
        }
    }
    return false;
}

function gffd_list_pages_with_gravity_forms() {
    $pages_with_forms = [];
    $post_types = get_post_types(['public' => true], 'names');
    $posts = get_posts([
        'post_type' => $post_types,
        'post_status' => ['publish', 'draft', 'private', 'future'],
        'numberposts' => -1
    ]);

    foreach ($posts as $post) {
        $content = $post->post_content;
        if (has_shortcode($content, 'gravityform') || strpos($content, '[gravityform') !== false) {
            $pages_with_forms[] = [
                'title' => $post->post_title,
                'url' => get_permalink($post->ID),
                'type' => $post->post_type,
                'status' => $post->post_status
            ];
        }
    }

    return $pages_with_forms;
}

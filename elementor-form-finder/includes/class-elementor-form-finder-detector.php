<?php
if (!defined('ABSPATH')) exit;

class Elementor_Form_Finder_Detector {

    public static function is_elementor_page($post_id) {
        $doc = \Elementor\Plugin::$instance->documents->get($post_id);
        return $doc && $doc->is_built_with_elementor();
    }

    public static function get_elementor_data($post_id) {
        $doc = \Elementor\Plugin::$instance->documents->get($post_id);
        return $doc ? $doc->get_elements_data() : [];
    }

    public static function has_direct_form($post_id) {
        $elements = self::get_elementor_data($post_id);
        return self::search_for_widget($elements, 'form');
    }

    public static function get_template_ids_used($post_id) {
        $elements = self::get_elementor_data($post_id);
        return self::extract_template_ids($elements);
    }

    public static function template_has_form($template_id) {
        if (!self::is_elementor_page($template_id)) return false;
        $elements = self::get_elementor_data($template_id);
        return self::search_for_widget($elements, 'form');
    }

    private static function search_for_widget($elements, $type) {
        foreach ($elements as $element) {
            if (isset($element['elType']) && $element['elType'] === 'widget' && $element['widgetType'] === $type) {
                return true;
            }
            if (!empty($element['elements']) && self::search_for_widget($element['elements'], $type)) {
                return true;
            }
        }
        return false;
    }

    private static function extract_template_ids($elements) {
        $template_ids = [];
        foreach ($elements as $element) {
            if (isset($element['elType']) && $element['widgetType'] === 'template') {
                if (!empty($element['settings']['template_id'])) {
                    $template_ids[] = (int) $element['settings']['template_id'];
                }
            }
            if (!empty($element['elements'])) {
                $template_ids = array_merge($template_ids, self::extract_template_ids($element['elements']));
            }
        }
        return array_unique($template_ids);
    }
}

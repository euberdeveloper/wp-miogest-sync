<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

class Resideo_Social_Widget extends WP_Widget {
    function __construct() {
        $widget_ops  = array('classname' => 'resideo_social_sidebar', 'description' => __('Social networks links', 'resideo'));
        $control_ops = array('id_base' => 'resideo_social_widget');

        parent::__construct('resideo_social_widget', __('Resideo Social Networks', 'resideo'), $widget_ops, $control_ops);
    }

    function form($instance) {
        $defaults = array(
            'title'     => '',
            'facebook'  => '',
            'twitter'   => '',
            'linkedin'  => '',
            'pinterest' => '',
            'instagram' => ''
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $display = '
            <p>
                <label for="' . esc_attr($this->get_field_id('title')) . '">' . __('Title', 'resideo') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('title')) . '" name="' . esc_attr($this->get_field_name('title')) . '" value="' . esc_attr($instance['title']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('instagram')) . '">' . __('Instagram Link', 'resideo') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('instagram')) . '" name="' . esc_attr($this->get_field_name('instagram')) . '" value="' . esc_attr($instance['instagram']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('facebook')) . '">' . __('Facebook Link', 'resideo') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('facebook')) . '" name="' . esc_attr($this->get_field_name('facebook')) . '" value="' . esc_attr($instance['facebook']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('twitter')) . '">' . __('Twitter Link', 'resideo') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('twitter')) . '" name="' . esc_attr($this->get_field_name('twitter')) . '" value="' . esc_attr($instance['twitter']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('linkedin')) . '">' . __('LinkedIn Link', 'resideo') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('linkedin')) . '" name="' . esc_attr($this->get_field_name('linkedin')) . '" value="' . esc_attr($instance['linkedin']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('pinterest')) . '">' . __('Pinterest Link', 'resideo') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('pinterest')) . '" name="' . esc_attr($this->get_field_name('pinterest')) . '" value="' . esc_attr($instance['pinterest']) . '" />
            </p>';

        print $display;
    }


    function update($new_instance, $old_instance) {
        $instance              = $old_instance;
        $instance['title']     = sanitize_text_field($new_instance['title']);
        $instance['instagram'] = sanitize_text_field($new_instance['instagram']);
        $instance['facebook']  = sanitize_text_field($new_instance['facebook']);
        $instance['twitter']   = sanitize_text_field($new_instance['twitter']);
        $instance['linkedin']  = sanitize_text_field($new_instance['linkedin']);
        $instance['pinterest'] = sanitize_text_field($new_instance['pinterest']);

        if (function_exists('icl_register_string')) {
            icl_register_string('resideo_social_widget', 'resideo_social_widget_title', sanitize_text_field($new_instance['title']));
            icl_register_string('resideo_social_widget', 'resideo_social_widget_instagram', sanitize_text_field($new_instance['instagram']));
            icl_register_string('resideo_social_widget', 'resideo_social_widget_facebook', sanitize_text_field($new_instance['facebook']));
            icl_register_string('resideo_social_widget', 'resideo_social_widget_twitter', sanitize_text_field($new_instance['twitter']));
            icl_register_string('resideo_social_widget', 'resideo_social_widget_linkedin', sanitize_text_field($new_instance['linkedin']));
            icl_register_string('resideo_social_widget', 'resideo_social_widget_pinterest', sanitize_text_field($new_instance['pinterest']));
        }

        return $instance;
    }

    function widget($args, $instance) {
        extract($args);

        $display = '';
        $title = apply_filters('widget_title', $instance['title']);

        print $before_widget;

        if ($title) {
            print $before_title . esc_html($title) . $after_title;
        }

        $display .= '<div>';

        if ($instance['instagram']) {
            if(function_exists('icl_t')) {
                $social_instagram = icl_t('resideo_social_widget', 'social_widget_instagram', $instance['instagram']);
            } else {
                $social_instagram = $instance['instagram'];
            }

            $display .= '<a href="' . esc_url($social_instagram) . '" target="_blank"><span class="fa fa-instagram"></span></a> ';
        }

        if ($instance['facebook']) {
            if (function_exists('icl_t')) {
                $social_facebook = icl_t('resideo_social_widget', 'social_widget_facebook', $instance['facebook']);
            } else {
                $social_facebook = $instance['facebook'];
            }

            $display .= '<a href="' . esc_url($social_facebook) . '" target="_blank"><span class="fa fa-facebook-square"></span></a> ';
        }

        if ($instance['twitter']) {
            if(function_exists('icl_t')) {
                $social_twitter = icl_t('resideo_social_widget', 'social_widget_twitter', $instance['twitter']);
            } else {
                $social_twitter = $instance['twitter'];
            }

            $display .= '<a href="' . esc_url($social_twitter) . '" target="_blank"><span class="fa fa-twitter"></span></a> ';
        }

        if ($instance['linkedin']) {
            if(function_exists('icl_t')) {
                $social_linkedin = icl_t('resideo_social_widget', 'social_widget_linkedin', $instance['linkedin']);
            } else {
                $social_linkedin = $instance['linkedin'];
            }

            $display .= '<a href="' . esc_url($social_linkedin) . '" target="_blank"><span class="fa fa-linkedin"></span></a> ';
        }

        if ($instance['pinterest']) {
            if(function_exists('icl_t')) {
                $social_pinterest = icl_t('resideo_social_widget', 'social_widget_google', $instance['pinterest']);
            } else {
                $social_pinterest = $instance['pinterest'];
            }

            $display .= '<a href="' . esc_url($social_pinterest) . '" target="_blank"><span class="fa fa-pinterest"></span></a> ';
        }

        $display .= '</div>';

        print $display;
        print $after_widget;
    }
}
?>
<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

/**
 * Promo shortcode
 */
if (!function_exists('resideo_promo_shortcode')): 
    function resideo_promo_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array('data_content'), $attrs));

        if (!isset($attrs['data_content'])) {
            return null;
        }

        $s_array = json_decode(urldecode($attrs['data_content']), true);

        $margin_class = $s_array['margin'] == 'yes' ? 'mt-100' : '';
        $section_class = 'pb-300';
        $caption_class = '';

        $image  = isset($s_array['image']) ? $s_array['image'] : '';
        if ($image != '') {
            $photo = wp_get_attachment_image_src($image, 'pxp-full');
            $photo_src = $photo[0];
        } else {
            $photo_src = '';
        }

        $cta_color = isset($s_array['cta_color']) ? $s_array['cta_color'] : '';
        $cta_id = uniqid();

        switch ($s_array['position']) {
            case 'topLeft':
                $section_class = 'pb-300';
                $caption_class = '';
            break;
            case 'topRight':
                $section_class = 'pb-300';
                $caption_class = 'justify-content-end';
            break;
            case 'centerLeft':
                $section_class = 'pt-200 pb-200';
                $caption_class = '';
            break;
            case 'center':
                $section_class = 'pt-200 pb-200';
                $caption_class = 'justify-content-center';
            break;
            case 'centerRight':
                $section_class = 'pt-200 pb-200';
                $caption_class = 'justify-content-end';
            break;
            case 'bottomLeft':
                $section_class = 'pt-300';
                $caption_class = '';
            break;
            case 'bottomRight':
                $section_class = 'pt-300';
                $caption_class = 'justify-content-end';
            break;
            default:
                $section_class = 'pb-300';
                $caption_class = '';
            break;
        }

        $return_string = 
            '<div class="pxp-cta-1 pxp-cover ' . esc_attr($margin_class) . ' ' . esc_attr($section_class) . '" style="background-image: url(' . esc_url($photo_src) . ')">
                <div class="container">
                    <div class="row ' . esc_attr($caption_class) . '">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="pxp-cta-1-caption pxp-animate-in">
                                <h2 class="pxp-section-h2">' . esc_html($s_array['title']) . '</h2>
                                <p class="pxp-text-light">' . esc_html($s_array['text']) . '</p>';
        if ($s_array['cta_text'] != '') {
            $return_string .= 
                                '<a href="' . esc_url($s_array['cta_link']) . '" class="pxp-primary-cta text-uppercase mt-3 mt-md-5 pxp-animate" id="cta-' . esc_attr($cta_id) . '" style="color: ' . esc_attr($cta_color) . '">' . esc_html($s_array['cta_text']) . '</a>
                                <style>.pxp-primary-cta#cta-' . esc_attr($cta_id) . ':after { border-top: 2px solid ' . esc_html($cta_color) . '; }</style>';
        }
        $return_string .= 
                            '</div>
                        </div>
                    </div>
                </div>
            </div>';

        return $return_string;
    }
endif;
?>
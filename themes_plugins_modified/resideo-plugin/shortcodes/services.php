<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

/**
 * Services shortcode
 */
if (!function_exists('resideo_services_shortcode')): 
    function resideo_services_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array('data_content'), $attrs));

        if (!isset($attrs['data_content'])) {
            return null;
        }

        $s_array = json_decode(urldecode($attrs['data_content']), true);

        $return_string = '';

        $margin_class = $s_array['margin'] == 'yes' ? 'mt-100' : '';

        $bg_image = wp_get_attachment_image_src($s_array['image'], 'pxp-full');
        $bg_image_src = '';
        if ($bg_image != false) {
            $bg_image_src = $bg_image[0];
        }

        switch ($s_array['layout']) {
            case '1':
                $return_string = '
                    <div class="pxp-services pxp-cover pt-100 mb-200 ' . esc_attr($margin_class) . '" style="background-image: url(' . esc_url($bg_image_src) . ');">
                        <h2 class="text-center pxp-section-h2">' . esc_html($s_array['title']) . '</h2>
                        <p class="pxp-text-light text-center">' . esc_html($s_array['subtitle']) . '</p>

                        <div class="container">
                            <div class="pxp-services-container rounded-lg mt-4 mt-md-5">';
                foreach ($s_array['services'] as $service) {
                    if ($service['link'] != '') {
                        $return_string .= 
                                '<a href="' . esc_url($service['link']) . '" class="pxp-services-item">';
                    } else {
                        $return_string .= 
                                '<div class="pxp-services-item">';
                    }
                    $return_string .= 
                                    '<div class="pxp-services-item-fig">';
                    if ($service['isicon'] == '1') {
                        $return_string .= 
                                        '<span class="' . esc_attr($service['value']) . '" style="color: ' . esc_attr($service['color']) . '"></span>';
                    } else {
                        $image_src = wp_get_attachment_image_src($service['value'], 'pxp-icon');
                        if ($image_src != false) {
                            $return_string .= 
                                        '<img src="' . esc_url($image_src[0]) . '" alt="' . esc_html($service['title']) . '" />';
                        }
                    }
                    $service_cta_color = isset($service['ctacolor']) ? $service['ctacolor'] : '';
                    $return_string .= 
                                    '</div>
                                    <div class="pxp-services-item-text text-center">
                                        <div class="pxp-services-item-text-title">' . esc_html($service['title']) . '</div>
                                        <div class="pxp-services-item-text-sub">' . esc_html($service['text']) . '</div>
                                    </div>
                                    <div class="pxp-services-item-cta text-uppercase text-center" style="color: ' . esc_attr($service_cta_color) . '">' . esc_html($service['cta']) . '</div>';
                    if ($service['link'] != '') {
                        $return_string .= 
                                '</a>';
                    } else {
                        $return_string .= 
                                '</div>';
                    }
                }
                $return_string .= 
                                '<div class="clearfix"></div>
                            </div>
                        </div>
                    </div>';
            break;
            case '2':
                $item_margin = '';
                $return_string = 
                    '<div class="pxp-services-h pt-100 pb-100 ' . esc_attr($margin_class) . '">
                        <div class="container">
                            <h2 class="pxp-section-h2">' . esc_html($s_array['title']) . '</h2>
                            <p class="pxp-text-light">' . esc_html($s_array['subtitle']) . '</p>

                            <div class="pxp-services-h-container mt-4 mt-md-5">
                                <div class="pxp-services-h-fig pxp-cover pxp-animate-in rounded-lg" style="background-image: url(' . esc_url($bg_image_src) . ');"></div>
                                <div class="pxp-services-h-items pxp-animate-in ml-0 ml-lg-5 mt-4 mt-md-5 mt-lg-0">';
                $service_i = 0;
                foreach ($s_array['services'] as $service) {
                    if ($service_i > 0) {
                        $item_margin = 'mt-3 mt-md-4';
                    }
                    $return_string .= 
                                    '<div class="pxp-services-h-item ' . esc_attr($item_margin) . '">
                                        <div class="media">';
                    if ($service['isicon'] == '1') {
                        $return_string .= 
                                            '<span class="mr-4 ' . esc_attr($service['value']) . '" style="color: ' . esc_attr($service['color']) . '"></span>';
                    } else {
                        $image_src = wp_get_attachment_image_src($service['value'], 'pxp-icon');
                        if ($image_src != false) {
                            $return_string .= 
                                            '<img src="' . esc_url($image_src[0]) . '" class="mr-4" alt="' . esc_attr($service['title']) . '" />';
                        }
                    }
                    $return_string .= 
                                            '<div class="media-body">
                                                <h5 class="mt-0">' . esc_attr($service['title']) . '</h5>
                                                ' . esc_html($service['text']) . '
                                            </div>
                                        </div>
                                    </div>';
                    $service_i++;
                }
                if ($s_array['cta_link'] != '') {
                    $return_string .= 
                                    '<a href="' . esc_url($s_array['cta_link']) . '" class="pxp-primary-cta text-uppercase mt-4 mt-md-5 pxp-animate pxp-animate-in">' . esc_html($s_array['cta_label']) . '</a>';
                }
                $return_string .= 
                                '</div>
                            </div>
                        </div>
                    </div>';
            break;
            case '3':
                $return_string = 
                    '<div class="pt-100 pb-100 position-relative ' . esc_attr($margin_class) . '">
                        <div class="pxp-services-c pxp-cover" style="background-image: url(' . esc_url($bg_image_src) . ');"></div>
                        <div class="pxp-services-c-content">
                            <div class="pxp-services-c-intro">
                                <h2 class="pxp-section-h2">' . esc_html($s_array['title']) . '</h2>
                                <p class="pxp-text-light">' . esc_html($s_array['subtitle']) . '</p>';
                if ($s_array['cta_link'] != '') {
                    $return_string .= 
                                '<a href="' . esc_url($s_array['cta_link']) . '" class="pxp-primary-cta text-uppercase mt-2 mt-md-3 mt-lg-5 pxp-animate">' . esc_html($s_array['cta_label']) . '</a>';
                }
                $return_string .=
                            '</div>
                            <div class="pxp-services-c-container mt-4 mt-md-5 mt-lg-0">
                                <div class="owl-carousel pxp-services-c-stage">';
                foreach ($s_array['services'] as $service) {
                    $return_string .=
                                    '<div>';
                    if ($service['link'] != '') {
                        $return_string .=
                                        '<a href="' . esc_url($service['link']) . '" class="pxp-services-c-item">';
                    } else {
                        $return_string .=
                                        '<div class="pxp-services-c-item">';
                    }
                    $return_string .=
                                            '<div class="pxp-services-c-item-fig">';
                    if ($service['isicon'] == '1') {
                        $return_string .= 
                                                '<span class="' . esc_attr($service['value']) . '" style="color: ' . esc_attr($service['color']) . '"></span>';
                    } else {
                        $image_src = wp_get_attachment_image_src($service['value'], 'pxp-icon');
                        if ($image_src != false) {
                            $return_string .= 
                                                '<img src="' . esc_url($image_src[0]) . '" alt="' . esc_attr($service['title']) . '" />';
                        }
                    }
                    $service_cta_color = isset($service['ctacolor']) ? $service['ctacolor'] : '';
                    $return_string .=
                                            '</div>
                                            <div class="pxp-services-c-item-text text-center">
                                                <div class="pxp-services-c-item-text-title">' . esc_html($service['title']) . '</div>
                                                <div class="pxp-services-c-item-text-sub">' . esc_html($service['text']) . '</div>
                                            </div>
                                            <div class="pxp-services-c-item-cta text-uppercase text-center" style="color: ' . esc_attr($service_cta_color) . '">' . esc_html($service['cta']) . '</div>
                                        </a>
                                    </div>';
                }
                $return_string .=
                                '</div>
                            </div>
                        </div>
                    </div>';
            break;
            case '4':
                $return_string = 
                    '<div class="pxp-services-columns ' . esc_attr($margin_class) . '">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <h2 class="pxp-section-h2">' . esc_html($s_array['title']) . '</h2>
                                    <p class="pxp-text-light">' . esc_html($s_array['subtitle']) . '</p>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <div class="row">';
                foreach ($s_array['services'] as $service) {
                    $return_string .=
                                        '<div class="col-sm-6">
                                            <div class="pxp-services-columns-item mb-3 mb-md-4">
                                                <div class="pxp-services-columns-item-fig">';
                    if ($service['isicon'] == '1') {
                        $return_string .= 
                                                    '<span class="' . esc_attr($service['value']) . '" style="color: ' . esc_attr($service['color']) . '"></span>';
                    } else {
                        $image_src = wp_get_attachment_image_src($service['value'], 'pxp-icon');
                        if ($image_src != false) {
                            $return_string .= 
                                                    '<img src="' . esc_url($image_src[0]) . '" alt="' . esc_attr($service['title']) . '" />';
                        }
                    }
                    $return_string .=
                                                '</div>
                                                <h3 class="mt-3">' . esc_html($service['title']) . '</h3>
                                                <p class="pxp-text-light">' . esc_html($service['text']) . '</p>
                                            </div>
                                        </div>';
                }
                $return_string .=
                                    '</div>
                                </div>
                            </div>
                        </div>
                    </div>';
            break;
            case '5':
                $acc_id = uniqid();
                if ($bg_image_src == '') {
                    $return_string = 
                        '<div class="pxp-services-accordion ' . esc_attr($margin_class) . '">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h2 class="pxp-section-h2">' . esc_html($s_array['title']) . '</h2>
                                        <p class="pxp-text-light">' . esc_html($s_array['subtitle']) . '</p>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-6">
                                        <div class="accordion" id="pxpServicesAccordion' . esc_attr($acc_id) . '">';
                    $count = 0;
                    foreach ($s_array['services'] as $service) {
                        $item_class = '';
                        $collapsed = '';
                        $show = 'show';
                        if ($count > 0) {
                            $item_class = 'mt-2 mt-md-3';
                            $collapsed = 'collapsed';
                            $show = '';
                        }
                        $return_string .= 
                                            '<div class="pxp-services-accordion-item ' . esc_attr($item_class) . '">
                                                <div class="pxp-services-accordion-item-header" id="pxpServicesAccordionHeading' . esc_attr($acc_id) . '-' . esc_attr($count) . '">
                                                    <h4 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left ' . esc_attr($collapsed) . '" type="button" data-toggle="collapse" data-target="#pxpServicesAccordionCollapse' . esc_attr($acc_id) . '-' . esc_attr($count) . '" aria-expanded="true" aria-controls="pxpServicesAccordionCollapse' . esc_attr($acc_id) . '-' . esc_attr($count) . '">
                                                            <span class="pxp-services-accordion-item-icon"></span> ' . esc_html($service['title']) . '
                                                        </button>
                                                    </h4>
                                                </div>
                                                <div id="pxpServicesAccordionCollapse' . esc_attr($acc_id) . '-' . esc_attr($count) . '" class="collapse ' . esc_attr($show) . '" aria-labelledby="pxpServicesAccordionHeading' . esc_attr($acc_id) . '-' . esc_attr($count) . '" data-parent="#pxpServicesAccordion' . esc_attr($acc_id) . '">
                                                    <div class="pxp-services-accordion-item-body pxp-text-light">' . esc_html($service['text']) . '</div>
                                                </div>
                                            </div>';
                        $count++;
                    }
                    $return_string .= 
                                        '</div>';
                    if ($s_array['cta_link'] != '') {
                        $return_string .= 
                                        '<a href="' . esc_url($s_array['cta_link']) . '" class="pxp-primary-cta text-uppercase mt-4 mt-md-5 pxp-animate">' . esc_html($s_array['cta_label']) . '</a>';
                    }
                    $return_string .= 
                                    '</div>
                                </div>
                            </div>
                        </div>';
                } else {
                    $return_string = 
                        '<div class="pxp-services-accordion pxp-services-accordion-has-image ' . esc_attr($margin_class) . '">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h2 class="pxp-section-h2">' . esc_html($s_array['title']) . '</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-6">
                                    <div class="pxp-services-accordion-fig pxp-cover" style="background-image: url(' . esc_url($bg_image_src) . ');"></div>
                                </div>
                                <div class="col-md-6 pxp-services-accordion-right">
                                    <div class="pxp-services-accordion-right-container">
                                        <div class="row">
                                            <div class="col-xl-10 col-xxl-6">
                                                <h3>' . esc_html($s_array['subtitle']) . '</h3>
                                                <div class="accordion mt-4 mt-md-5" id="pxpServicesAccordionFig' . esc_attr($acc_id) . '">';
                    $count = 0;
                    foreach ($s_array['services'] as $service) {
                        $item_class = '';
                        $collapsed = '';
                        $show = 'show';
                        if ($count > 0) {
                            $item_class = 'mt-2 mt-md-3';
                            $collapsed = 'collapsed';
                            $show = '';
                        }
                        $return_string .= 
                                                    '<div class="pxp-services-accordion-item ' . esc_attr($item_class) . '">
                                                        <div class="pxp-services-accordion-item-header" id="pxpServicesAccordionFigHeading' . esc_attr($acc_id) . '-' . esc_attr($count) . '">
                                                            <h4 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left ' . esc_attr($collapsed) . '" type="button" data-toggle="collapse" data-target="#pxpServicesAccordionFigCollapse' . esc_attr($acc_id) . '-' . esc_attr($count) . '" aria-expanded="true" aria-controls="pxpServicesAccordionFigCollapse' . esc_attr($acc_id) . '-' . esc_attr($count) . '">
                                                                    <span class="pxp-services-accordion-item-icon"></span> ' . esc_html($service['title']) . '
                                                                </button>
                                                            </h4>
                                                        </div>
                                                        <div id="pxpServicesAccordionFigCollapse' . esc_attr($acc_id) . '-' . esc_attr($count) . '" class="collapse ' . esc_attr($show) . '" aria-labelledby="pxpServicesAccordionFigHeading' . esc_attr($acc_id) . '-' . esc_attr($count) . '" data-parent="#pxpServicesAccordionFig' . esc_attr($acc_id) . '">
                                                            <div class="pxp-services-accordion-item-body pxp-text-light">' . esc_html($service['text']) . '</div>
                                                        </div>
                                                    </div>';
                        $count++;
                    }
                    $return_string .= 
                                                '</div>';
                    if ($s_array['cta_link'] != '') {
                        $return_string .= 
                                                '<a href="' . esc_url($s_array['cta_link']) . '" class="pxp-primary-cta text-uppercase mt-4 mt-md-5 pxp-animate">' . esc_html($s_array['cta_label']) . '</a>';
                    }
                    $return_string .=
                                            '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
            break;
            default:
                $return_string = '
                    <div class="pxp-services pxp-cover pt-100 mb-200 ' . esc_attr($margin_class) . '" style="background-image: url(' . esc_url($bg_image_src) . ');">
                        <h2 class="text-center pxp-section-h2">' . esc_html($s_array['title']) . '</h2>
                        <p class="pxp-text-light text-center">' . esc_html($s_array['subtitle']) . '</p>

                        <div class="container">
                            <div class="pxp-services-container rounded-lg mt-4 mt-md-5">';
                foreach ($s_array['services'] as $service) {
                    if ($service['link'] != '') {
                        $return_string .= 
                                '<a href="' . esc_url($service['link']) . '" class="pxp-services-item">';
                    } else {
                        $return_string .= 
                                '<div class="pxp-services-item">';
                    }
                    $return_string .= 
                                    '<div class="pxp-services-item-fig">';
                    if ($service['isicon'] == '1') {
                        $return_string .= 
                                        '<span class="' . esc_attr($service['value']) . '" style="color: ' . esc_attr($service['color']) . '"></span>';
                    } else {
                        $image_src = wp_get_attachment_image_src($service['value'], 'pxp-icon');
                        if ($image_src != false) {
                            $return_string .= 
                                        '<img src="' . esc_url($image_src[0]) . '" alt="' . esc_attr($s_array['title']) . '" />';
                        }
                    }
                    $service_cta_color = isset($service['ctacolor']) ? $service['ctacolor'] : '';
                    $return_string .= 
                                    '</div>
                                    <div class="pxp-services-item-text text-center">
                                        <div class="pxp-services-item-text-title">' . esc_html($service['title']) . '</div>
                                        <div class="pxp-services-item-text-sub">' . esc_html($service['text']) . '</div>
                                    </div>
                                    <div class="pxp-services-item-cta text-uppercase text-center" style="color: ' . esc_attr($service_cta_color) . '">' . esc_html($service['cta']) . '</div>';
                    if ($service['link'] != '') {
                        $return_string .= 
                                '</a>';
                    } else {
                        $return_string .= 
                                '</div>';
                    }
                }
                $return_string .= 
                                '<div class="clearfix"></div>
                            </div>
                        </div>
                    </div>';
            break;
        }

        return $return_string;
    }
endif;
?>
<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

/**
 * Contact shortcode
 */
if (!function_exists('resideo_contact_shortcode')): 
    function resideo_contact_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array('data_content'), $attrs));

        $s_array = json_decode(urldecode($attrs['data_content']), true);

        $title        = isset($s_array['title']) ? $s_array['title'] : '';
        $subtitle     = isset($s_array['subtitle']) ? $s_array['subtitle'] : '';
        $name         = isset($s_array['name']) ? $s_array['name'] : '';
        $phone        = isset($s_array['phone']) ? $s_array['phone'] : '';
        $address      = isset($s_array['address']) ? $s_array['address'] : '';
        $lat          = isset($s_array['lat']) ? $s_array['lat'] : '';
        $lng          = isset($s_array['lng']) ? $s_array['lng'] : '';
        $marker       = isset($s_array['marker']) ? $s_array['marker'] : '';
        $form         = isset($s_array['form']) ? $s_array['form'] : '';
        $email        = isset($s_array['email']) ? $s_array['email'] : '';
        $map_position = isset($s_array['map_position']) ? $s_array['map_position'] : '';
        $width        = isset($s_array['width']) ? $s_array['width'] : '';
        $margin       = isset($s_array['margin']) ? $s_array['margin'] : '';

        if ($map_position == 'right') {
            $position_class = 'isLeft';
        } else {
            $position_class = 'isRight';
        }

        if ($width == 'wide') {
            $wide_class = 'extendFull';
        } else {
            $wide_class = '';
        }

        $margin_class = '';
        if ($margin == 'yes') {
            $margin_class = 'mb-60';
        }

        if ($marker != '') {
            $marker_img = wp_get_attachment_image_src($marker, 'pxp-full');
            $marker_src = $marker_img[0];
        } else {
            $marker_src = RESIDEO_PLUGIN_PATH . 'images/contact-marker-default.png';
        }

        $return_string = '
            <div class="contact-short ' . esc_attr($position_class) . ' ' . esc_attr($wide_class) . ' ' . esc_attr($margin_class) . '">
                <div class="contact-short-details">
                    <h2 class="centered playfair">' . esc_html($title) . '</h2>
                    <h3 class="centered short-sub">' . esc_html($subtitle) . '</h3>
                    <div class="contact-short-details-info">
                        <div class="contact-short-details-company">' . esc_html($name) . '</div>
                        <div class="contact-short-details-phone"><span class="fa fa-phone"></span> ' . esc_html($phone) . '</div>
                        <div class="contact-short-details-address">' . esc_html($address) . '</div>';
        if ($form == 'yes') {
            $return_string .= '
                        <div class="contact-short-details-cta">
                            <a href="javascript:void(0);" class="btn btn-color btn-lg">' . __('Send Us a Message', 'resideo') . '</a>
                        </div>';
        }
        $return_string .= '
                    </div>';
        if ($form == 'yes') {
            $return_string .= '
                    <div class="contact-short-details-form">
                        <div class="contact-short-details-form-response"></div>
                        <input type="hidden" id="contact_short_receiver_email" name="contact_short_receiver_email" value="' . esc_attr($email) . '">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="contact_short_name" id="contact_short_name" placeholder="' . __('Name', 'resideo') . '">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="contact_short_email" id="contact_short_email" placeholder="' . __('Email', 'resideo') . '">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" type="text" name="contact_short_message" id="contact_short_message" placeholder="' . __('Message', 'resideo') . '"></textarea>
                        </div>
                        <a href="javascript:void(0);" class="btn btn-lg btn-color" id="contact-short-details-form-send">
                            <span id="contact-short-details-form-send-text">' . __('Send', 'resideo') . '</span>
                            <span id="contact-short-details-form-sending-text" class=""><img src="' . esc_url(RESIDEO_PLUGIN_PATH . 'images/loader-light.svg') . '" class="loader"> ' . __('Sending...', 'resideo') . '</span>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-lg btn-nocolor" id="contact-short-details-form-cancel">' . __('Cancel', 'resideo') . '</a>'
                        . wp_nonce_field('contact_form_shortcode_ajax_nonce', 'contact_short_security', true, true) . 
                    '</div>';
        }
        $return_string .= '
                </div>
                <div class="contact-short-map" id="contactMap" data-lat="' . esc_attr($lat) . '" data-lng="' . esc_attr($lng) . '" data-marker="' . esc_url($marker_src) . '"></div>
            </div>';

        return $return_string;
    }
endif;
?>
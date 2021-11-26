<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

require_once 'services.php';
require_once 'recent_properties.php';
require_once 'featured_properties.php';
require_once 'single_property.php';
require_once 'search_properties.php';
require_once 'areas.php';
require_once 'featured_agents.php';
require_once 'membership_plans.php';
require_once 'recent_posts.php';
require_once 'featured_posts.php';
require_once 'testimonials.php';
require_once 'promo.php';
require_once 'slider_promo.php';
require_once 'subscribe.php';
require_once 'gallery_carousel.php';
require_once 'numbers.php';
require_once 'awards.php';

if (!function_exists('resideo_register_shortcodes_buttons')): 
    function resideo_register_shortcodes_buttons($buttons) {
        global $post;

        $buttons = array();

        if (isset($post)) {
            if ($post->post_type == 'page') {
                array_push($buttons, "", "res_services");
                array_push($buttons, "", "res_recent_properties");
                array_push($buttons, "", "res_featured_properties");
                array_push($buttons, "", "res_single_property");
                array_push($buttons, "", "res_search_properties");
                array_push($buttons, "", "res_areas");
                array_push($buttons, "", "res_featured_agents");
                array_push($buttons, "", "res_membership_plans");
                array_push($buttons, "", "res_recent_posts");
                array_push($buttons, "", "res_featured_posts");
                array_push($buttons, "", "res_testimonials");
                array_push($buttons, "", "res_promo");
                array_push($buttons, "", "res_slider_promo");
                array_push($buttons, "", "res_subscribe");
                array_push($buttons, "", "res_gallery_carousel");
                array_push($buttons, "", "res_numbers");
                array_push($buttons, "", "res_awards");
            }
        }

        return $buttons;
    }
endif;

if (!function_exists('resideo_add_plugins')): 
    function resideo_add_plugins($plugin_array) {
        $plugin_array['res_services']            = RESIDEO_PLUGIN_PATH . 'shortcodes/js/services.js';
        $plugin_array['res_recent_properties']   = RESIDEO_PLUGIN_PATH . 'shortcodes/js/recent-properties.js';
        $plugin_array['res_featured_properties'] = RESIDEO_PLUGIN_PATH . 'shortcodes/js/featured-properties.js';
        $plugin_array['res_single_property']     = RESIDEO_PLUGIN_PATH . 'shortcodes/js/single-property.js';
        $plugin_array['res_search_properties']   = RESIDEO_PLUGIN_PATH . 'shortcodes/js/search-properties.js';
        $plugin_array['res_areas']               = RESIDEO_PLUGIN_PATH . 'shortcodes/js/areas.js';
        $plugin_array['res_featured_agents']     = RESIDEO_PLUGIN_PATH . 'shortcodes/js/featured-agents.js';
        $plugin_array['res_membership_plans']    = RESIDEO_PLUGIN_PATH . 'shortcodes/js/membership-plans.js';
        $plugin_array['res_recent_posts']        = RESIDEO_PLUGIN_PATH . 'shortcodes/js/recent-posts.js';
        $plugin_array['res_featured_posts']      = RESIDEO_PLUGIN_PATH . 'shortcodes/js/featured-posts.js';
        $plugin_array['res_testimonials']        = RESIDEO_PLUGIN_PATH . 'shortcodes/js/testimonials.js';
        $plugin_array['res_promo']               = RESIDEO_PLUGIN_PATH . 'shortcodes/js/promo.js';
        $plugin_array['res_slider_promo']        = RESIDEO_PLUGIN_PATH . 'shortcodes/js/slider-promo.js';
        $plugin_array['res_subscribe']           = RESIDEO_PLUGIN_PATH . 'shortcodes/js/subscribe.js';
        $plugin_array['res_gallery_carousel']    = RESIDEO_PLUGIN_PATH . 'shortcodes/js/gallery-carousel.js';
        $plugin_array['res_numbers']             = RESIDEO_PLUGIN_PATH . 'shortcodes/js/numbers.js';
        $plugin_array['res_awards']              = RESIDEO_PLUGIN_PATH . 'shortcodes/js/awards.js';

        if(is_rtl()) {
            wp_enqueue_style('res_custom_rtl');
        } else {
            wp_enqueue_style('res_custom');
        }

        wp_enqueue_script('res_modal');
        wp_enqueue_style('font-awesome');
        wp_enqueue_style('simple-line-icons');

        return $plugin_array;
    }
endif;

if (!function_exists('resideo_register_plugin_buttons')): 
    function resideo_register_plugin_buttons() {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        add_editor_style(RESIDEO_PLUGIN_PATH . 'shortcodes/css/editor.css');

        if (get_user_option('rich_editing') == 'true') {
            add_filter('mce_external_plugins', 'resideo_add_plugins');
            add_filter('mce_buttons_3', 'resideo_register_shortcodes_buttons');
        }
    }
endif;

if (!function_exists('resideo_admin_enqueue_shortcodes_scripts')): 
    function resideo_admin_enqueue_shortcodes_scripts() {
        wp_enqueue_style('wp-color-picker', false, true);
        wp_enqueue_script('wp-color-picker', false, true);

        if (is_rtl()) {
            wp_register_style('res_custom_rtl', RESIDEO_PLUGIN_PATH . 'shortcodes/css/custom-rtl.css');
        } else {
            wp_register_style('res_custom', RESIDEO_PLUGIN_PATH . 'shortcodes/css/custom.css');
        }

        wp_register_style('font-awesome', RESIDEO_PLUGIN_PATH . 'css/font-awesome.min.css', array(), '4.7.0', 'all');
        wp_register_style('simple-line-icons', RESIDEO_PLUGIN_PATH . 'css/simple-line-icons.css', array(), '2.3.2', 'all');
    }
endif;

if (!function_exists('resideo_register_shortcodes')): 
    function resideo_register_shortcodes() {
        add_shortcode('res_services', 'resideo_services_shortcode');
        add_shortcode('res_recent_properties', 'resideo_recent_properties_shortcode');
        add_shortcode('res_featured_properties', 'resideo_featured_properties_shortcode');
        add_shortcode('res_single_property', 'resideo_single_property_shortcode');
        add_shortcode('res_search_properties', 'resideo_search_properties_shortcode');
        add_shortcode('res_areas', 'resideo_areas_shortcode');
        add_shortcode('res_featured_agents', 'resideo_featured_agents_shortcode');
        add_shortcode('res_membership_plans', 'resideo_membership_plans_shortcode');
        add_shortcode('res_recent_posts', 'resideo_recent_posts_shortcode');
        add_shortcode('res_featured_posts', 'resideo_featured_posts_shortcode');
        add_shortcode('res_testimonials', 'resideo_testimonials_shortcode');
        add_shortcode('res_promo', 'resideo_promo_shortcode');
        add_shortcode('res_slider_promo', 'resideo_slider_promo_shortcode');
        add_shortcode('res_subscribe', 'resideo_subscribe_shortcode');
        add_shortcode('res_gallery_carousel', 'resideo_gallery_carousel_shortcode');
        add_shortcode('res_numbers', 'resideo_numbers_shortcode');
        add_shortcode('res_awards', 'resideo_awards_shortcode');
        add_action('admin_enqueue_scripts', 'resideo_admin_enqueue_shortcodes_scripts');
    }
endif;

foreach (array('post.php', 'post-new.php') as $hook) {
    add_action("admin_head-$hook", 'resideo_admin_head');
    add_action("admin_head-$hook", 'resideo_register_plugin_buttons');
}

if (!function_exists('resideo_get_sh_cities')): 
    function resideo_get_sh_cities() {
        $resideo_cities_settings = get_option('resideo_cities_settings');

        if (is_array($resideo_cities_settings) && count($resideo_cities_settings) > 0) {
            uasort($resideo_cities_settings, "resideo_compare_position");

            $cities = array();

            foreach ($resideo_cities_settings as $key => $value) {
                $city = new stdClass();

                $city->id = $key;
                $city->name = $value['name'];

                array_push($cities, $city);
            }

            return urlencode(json_encode($cities, true));
        } else {
            return '';
        }
    }
endif;

if (!function_exists('resideo_get_sh_neighborhoods')): 
    function resideo_get_sh_neighborhoods() {
        $resideo_neighborhoods_settings = get_option('resideo_neighborhoods_settings');

        if (is_array($resideo_neighborhoods_settings) && count($resideo_neighborhoods_settings) > 0) {
            uasort($resideo_neighborhoods_settings, "resideo_compare_position");

            $neighborhoods = array();

            foreach ($resideo_neighborhoods_settings as $key => $value) {
                $neighborhood = new stdClass();

                $neighborhood->id = $key;
                $neighborhood->name = $value['name'];

                array_push($neighborhoods, $neighborhood);
            }

            return urlencode(json_encode($neighborhoods, true));
        } else {
            return '';
        }
    }
endif;

if (!function_exists('resideo_get_sh_properties')): 
    function resideo_get_sh_properties() {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'property',
            'orderby'        => 'post_title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        );
        $props = array();

        $posts = get_posts($args);

        foreach ($posts as $post) : setup_postdata($post);
            $prop = new stdClass();

            $prop->id = $post->ID;
            $prop->title = $post->post_title;

            array_push($props, $prop);
        endforeach;

        wp_reset_postdata();
        wp_reset_query();

        if (count($props) > 0) {
            return urlencode(json_encode($props, true));
        } else {
            return '';
        }
    }
endif;

if (!function_exists('resideo_get_sh_property_custom_fields')): 
    function resideo_get_sh_property_custom_fields() {
        $custom_fields_settings = get_option('resideo_fields_settings');

        if (is_array($custom_fields_settings)) {
            uasort($custom_fields_settings, "resideo_compare_position");

            return urlencode(json_encode($custom_fields_settings, true));
        } else {
            return '';
        }
    }
endif;

function resideo_admin_head() {
    $plugin_url = plugins_url('/', __FILE__);

    $fields_settings   = get_option('resideo_prop_fields_settings');
    $city_type         = isset($fields_settings['resideo_p_city_t_field']) ? $fields_settings['resideo_p_city_t_field'] : '';
    $neighborhood_type = isset($fields_settings['resideo_p_neighborhood_t_field']) ? $fields_settings['resideo_p_neighborhood_t_field'] : '';

    $resideo_gmaps_settings = get_option('resideo_gmaps_settings', '');
    $default_lat            = isset($resideo_gmaps_settings['resideo_gmaps_lat_field']) ? $resideo_gmaps_settings['resideo_gmaps_lat_field'] : '';
    $default_lng            = isset($resideo_gmaps_settings['resideo_gmaps_lng_field']) ? $resideo_gmaps_settings['resideo_gmaps_lng_field'] : '';

    $resideo_general_settings = get_option('resideo_general_settings', '');
    $auto_country             = isset($resideo_general_settings['resideo_auto_country_field']) ? $resideo_general_settings['resideo_auto_country_field'] : '';

    $appearance_settings = get_option('resideo_appearance_settings');
    $hide_agents_phone = isset($appearance_settings['resideo_hide_agents_phone_field']) ? $appearance_settings['resideo_hide_agents_phone_field'] : ''; ?>

    <!-- TinyMCE Shortcode Plugin -->
    <script type='text/javascript'>
    var sh_vars = {
        'admin_url'                           : '<?php echo get_admin_url(); ?>',
        'ajaxurl'                             : '<?php echo admin_url('admin-ajax.php'); ?>',
        'plugin_url'                          : '<?php echo RESIDEO_PLUGIN_PATH; ?>',
        'services_title'                      : '<?php echo __('Services', 'resideo'); ?>',
        'cancel_btn'                          : '<?php echo __('Cancel', 'resideo'); ?>',
        'insert_btn'                          : '<?php echo __('Insert', 'resideo'); ?>',
        'title_label'                         : '<?php echo __('Title', 'resideo'); ?>',
        'title_placeholder'                   : '<?php echo __('Enter title', 'resideo'); ?>',
        'subtitle_label'                      : '<?php echo __('Subtitle', 'resideo'); ?>',
        'subtitle_placeholder'                : '<?php echo __('Enter subtitle', 'resideo'); ?>',
        'services_list'                       : '<?php echo __('Services List', 'resideo'); ?>',
        'add_service_btn'                     : '<?php echo __('Add New Service', 'resideo'); ?>',
        'empty_list'                          : '<?php echo __('The list is empty.', 'resideo'); ?>',
        'service_title_label'                 : '<?php echo __('Service Title', 'resideo'); ?>',
        'service_title_placeholder'           : '<?php echo __('Enter service title', 'resideo'); ?>',
        'service_text_label'                  : '<?php echo __('Service Text', 'resideo'); ?>',
        'service_text_placeholder'            : '<?php echo __('Enter service text', 'resideo'); ?>',
        'new_service_header'                  : '<?php echo __('New Service', 'resideo'); ?>',
        'service_link_label'                  : '<?php echo __('Service Link', 'resideo'); ?>',
        'service_link_placeholder'            : '<?php echo __('Enter service link', 'resideo'); ?>',
        'service_cta_label'                   : '<?php echo __('Service CTA Label', 'resideo'); ?>',
        'service_cta_label_placeholder'       : '<?php echo __('Enter service CTA lablel', 'resideo'); ?>',
        'ok_service_btn'                      : '<?php echo __('Add', 'resideo'); ?>',
        'cancel_service_btn'                  : '<?php echo __('Cancel', 'resideo'); ?>',
        'service_add_img'                     : '<?php echo __('Add Image', 'resideo'); ?>',
        'service_add_icon'                    : '<?php echo __('Add Icon', 'resideo'); ?>',
        'service_image'                       : '<?php echo __('Service Image', 'resideo'); ?>',
        'service_insert_image'                : '<?php echo __('Insert Image', 'resideo'); ?>',
        'edit_service_header'                 : '<?php echo __('Edit Service', 'resideo'); ?>',
        'ok_edit_service_btn'                 : '<?php echo __('OK', 'resideo'); ?>',
        'service_icon_color'                  : '<?php echo __('Icon Color', 'resideo'); ?>',
        'recent_properties_title'             : '<?php echo __('Recent Properties', 'resideo'); ?>',
        'featured_properties_title'           : '<?php echo __('Featured Properties', 'resideo'); ?>',
        'remove_btn'                          : '<?php echo __('Remove', 'resideo'); ?>',
        'edit_btn'                            : '<?php echo __('Edit', 'resideo'); ?>',
        'all_label'                           : '<?php echo __('All', 'resideo'); ?>',
        'type_label'                          : '<?php echo __('Type', 'resideo'); ?>',
        'status_label'                        : '<?php echo __('Status', 'resideo'); ?>',
        'prop_number_label'                   : '<?php echo __('Number of Properties', 'resideo'); ?>',
        'prop_number_placeholder'             : '<?php echo __('Enter number of properties', 'resideo'); ?>',
        'cards_design_label'                  : '<?php echo __('Cards Design', 'resideo'); ?>',
        'cards_display_label'                 : '<?php echo __('Display', 'resideo'); ?>',
        'columns_type_label'                  : '<?php echo __('Column Type', 'resideo'); ?>',
        'sh_delete_confirmation'              : '<?php echo __('Are you sure you want to delete the shortcode?', 'resideo'); ?>',
        'info_title'                          : '<?php echo __('Info', 'resideo'); ?>',
        'cta_text_label'                      : '<?php echo __('CTA Button Text', 'resideo'); ?>',
        'cta_text_placeholder'                : '<?php echo __('Enter the CTA button text', 'resideo'); ?>',
        'cta_link_label'                      : '<?php echo __('CTA Button Link', 'resideo'); ?>',
        'cta_link_placeholder'                : '<?php echo __('Enter the CTA button link', 'resideo'); ?>',
        'card_cta_text_label'                 : '<?php echo __('Agent Card CTA text', 'resideo'); ?>',
        'card_cta_text_placeholder'           : '<?php echo __('Enter the CTA text', 'resideo'); ?>',
        'img_label'                           : '<?php echo __('Background Image', 'resideo'); ?>',
        'media_info_image_title'              : '<?php echo __('Info Background Image', 'resideo'); ?>',
        'media_info_image_btn'                : '<?php echo __('Insert Image', 'resideo'); ?>',
        'media_services_image_title'          : '<?php echo __('Services Background Image', 'resideo'); ?>',
        'media_services_image_btn'            : '<?php echo __('Insert Image', 'resideo'); ?>',
        'color_label'                         : '<?php echo __('Background Color', 'resideo'); ?>',
        'color_opacity_label'                 : '<?php echo __('Background Color Opacity', 'resideo'); ?>',
        'width_label'                         : '<?php echo __('Width', 'resideo'); ?>',
        'wide_label'                          : '<?php echo __('Wide', 'resideo'); ?>',
        'boxed_label'                         : '<?php echo __('Boxed', 'resideo'); ?>',
        'height_label'                        : '<?php echo __('Height', 'resideo'); ?>',
        'height_placeholder'                  : '<?php echo __('Enter the height', 'resideo'); ?>',
        'search_properties_title'             : '<?php echo __('Search Properties', 'resideo'); ?>',
        'fields_list_label'                   : '<?php echo __('Fields List', 'resideo'); ?>',
        'sp_id_label'                         : '<?php echo __('Property ID', 'resideo'); ?>',
        'sp_address_label'                    : '<?php echo __('Address', 'resideo'); ?>',
        'sp_city_label'                       : '<?php echo __('City', 'resideo'); ?>',
        'sp_neighborhood_label'               : '<?php echo __('Neighborhood', 'resideo'); ?>',
        'sp_state_label'                      : '<?php echo __('County/State', 'resideo'); ?>',
        'sp_price_label'                      : '<?php echo __('Price', 'resideo'); ?>',
        'sp_size_label'                       : '<?php echo __('Size', 'resideo'); ?>',
        'sp_beds_label'                       : '<?php echo __('Beds', 'resideo'); ?>',
        'sp_baths_label'                      : '<?php echo __('Baths', 'resideo'); ?>',
        'sp_type_label'                       : '<?php echo __('Type', 'resideo'); ?>',
        'sp_status_label'                     : '<?php echo __('Status', 'resideo'); ?>',
        'sp_keywords_label'                   : '<?php echo __('Keywords', 'resideo'); ?>',
        'sp_amenities_label'                  : '<?php echo __('Amenities', 'resideo'); ?>',
        'custom_fields_list_label'            : '<?php echo __('Custom Fields List', 'resideo'); ?>',
        'limit_main_fields_label'             : '<?php echo __('Limit Main Fields', 'resideo'); ?>',
        'fields_display_label'                : '<?php echo __('Display', 'resideo'); ?>',
        'fields_main_area_label'              : '<?php echo __('fields in main area', 'resideo'); ?>',
        'areas_title'                         : '<?php echo __('Areas', 'resideo'); ?>',
        'areas_list'                          : '<?php echo __('Areas List', 'resideo'); ?>',
        'add_area_btn'                        : '<?php echo __('Add New Area', 'resideo'); ?>',
        'new_area_header'                     : '<?php echo __('New Area', 'resideo'); ?>',
        'area_add_img'                        : '<?php echo __('Add Image', 'resideo'); ?>',
        'area_neighborhood_label'             : '<?php echo __('Neighborhood', 'resideo'); ?>',
        'area_neighborhood_placeholder'       : '<?php echo __('Enter neighborhood', 'resideo'); ?>',
        'area_city_label'                     : '<?php echo __('City', 'resideo'); ?>',
        'area_city_placeholder'               : '<?php echo __('Enter city', 'resideo'); ?>',
        'ok_area_btn'                         : '<?php echo __('Add', 'resideo'); ?>',
        'cancel_area_btn'                     : '<?php echo __('Cancel', 'resideo'); ?>',
        'edit_area_header'                    : '<?php echo __('Edit Area', 'resideo'); ?>',
        'ok_edit_area_btn'                    : '<?php echo __('OK', 'resideo'); ?>',
        'cancel_edit_area_btn'                : '<?php echo __('Cancel', 'resideo'); ?>',
        'area_image'                          : '<?php echo __('Area Image', 'resideo'); ?>',
        'area_insert_image'                   : '<?php echo __('Insert Image', 'resideo'); ?>',
        'areas_cities_list'                   : '<?php echo resideo_get_sh_cities(); ?>',
        'areas_neighborhoods_list'            : '<?php echo resideo_get_sh_neighborhoods(); ?>',
        'areas_city_type'                     : '<?php echo esc_html($city_type); ?>',
        'areas_neighborhood_type'             : '<?php echo esc_html($neighborhood_type); ?>',
        'areas_select_neighborhood'           : '<?php echo __('Select a neighborhood', 'resideo'); ?>',
        'areas_select_city'                   : '<?php echo __('Select a city', 'resideo'); ?>',
        'properties_title'                    : '<?php echo __('Properties Slider', 'resideo'); ?>',
        'properties_list'                     : '<?php echo __('Properties List', 'resideo'); ?>',
        'add_property_btn'                    : '<?php echo __('Add Property', 'resideo'); ?>',
        'modal_properties'                    : '<?php echo __('Properties', 'resideo'); ?>',
        'search_properties'                   : '<?php echo __('Search properties', 'resideo'); ?>',
        'modal_properties_results'            : '<?php echo __('Properties', 'resideo'); ?>',
        'load_more_properties'                : '<?php echo __('Load 20 more properties', 'resideo'); ?>',
        'modal_no_properties'                 : '<?php echo __('No properties found.', 'resideo'); ?>',
        'autoslide_label'                     : '<?php echo __('Autoslide', 'resideo'); ?>',
        'autoslide_no'                        : '<?php echo __('No', 'resideo'); ?>',
        'autoslide_yes'                       : '<?php echo __('Yes', 'resideo'); ?>',
        'interval_label'                      : '<?php echo __('Autoslide Interval', 'resideo'); ?>',
        'seconds_label'                       : '<?php echo __('seconds', 'resideo'); ?>',
        'transition_label'                    : '<?php echo __('Transition', 'resideo'); ?>',
        'margin_label'                        : '<?php echo __('Margin', 'resideo'); ?>',
        'margin_no'                           : '<?php echo __('No', 'resideo'); ?>',
        'margin_yes'                          : '<?php echo __('Yes', 'resideo'); ?>',
        'transition_slide'                    : '<?php echo __('Slide', 'resideo'); ?>',
        'transition_fade'                     : '<?php echo __('Fade', 'resideo'); ?>',
        'opacity_label'                       : '<?php echo __('Caption Background Opacity', 'resideo'); ?>',
        'width_label'                         : '<?php echo __('Width', 'resideo'); ?>',
        'width_wide'                          : '<?php echo __('Wide', 'resideo'); ?>',
        'width_boxed'                         : '<?php echo __('Boxed', 'resideo'); ?>',
        'recent_posts_title'                  : '<?php echo __('Recent Blog Posts', 'resideo'); ?>',
        'posts_number_label'                  : '<?php echo __('Number of Posts', 'resideo'); ?>',
        'posts_number_placeholder'            : '<?php echo __('Enter number of posts', 'resideo'); ?>',
        'featured_posts_title'                : '<?php echo __('Featured Blog Posts', 'resideo'); ?>',
        'featured_agents_title'               : '<?php echo __('Featured Agents', 'resideo'); ?>',
        'agents_number_label'                 : '<?php echo __('Number of Agents', 'resideo'); ?>',
        'agents_number_placeholder'           : '<?php echo __('Enter number of agents', 'resideo'); ?>',
        'testimonials_title'                  : '<?php echo __('Testimonials', 'resideo'); ?>',
        'media_testimonials_image_title'      : '<?php echo __('Testimonials Background Image', 'resideo'); ?>',
        'media_testimonials_image_btn'        : '<?php echo __('Insert Image', 'resideo'); ?>',
        'membership_plans_title'              : '<?php echo __('Membership Plans', 'resideo'); ?>',
        'columns_title'                       : '<?php echo __('Columns', 'resideo'); ?>',
        'contact_title'                       : '<?php echo __('Contact', 'resideo'); ?>',
        'business_name_label'                 : '<?php echo __('Business Name', 'resideo'); ?>',
        'business_name_placeholder'           : '<?php echo __('Enter company/business name', 'resideo'); ?>',
        'phone_label'                         : '<?php echo __('Phone Number', 'resideo'); ?>',
        'phone_placeholder'                   : '<?php echo __('Enter phone number', 'resideo'); ?>',
        'address_label'                       : '<?php echo __('Address', 'resideo'); ?>',
        'address_placeholder'                 : '<?php echo __('Enter address', 'resideo'); ?>',
        'position_btn'                        : '<?php echo __('Position pin by address', 'resideo'); ?>',
        'lat_label'                           : '<?php echo __('Latitude', 'resideo'); ?>',
        'lat_placeholder'                     : '<?php echo __('Enter latitude', 'resideo'); ?>',
        'lng_label'                           : '<?php echo __('Longitude', 'resideo'); ?>',
        'lng_placeholder'                     : '<?php echo __('Enter longitude', 'resideo'); ?>',
        'email_label'                         : '<?php echo __('Email address', 'resideo'); ?>',
        'email_placeholder'                   : '<?php echo __('Enter email address', 'resideo'); ?>',
        'form_label'                          : '<?php echo __('Display Contact Form', 'resideo'); ?>',
        'form_no'                             : '<?php echo __('No', 'resideo'); ?>',
        'form_yes'                            : '<?php echo __('Yes', 'resideo'); ?>',
        'default_lat'                         : '<?php echo esc_html($default_lat); ?>',
        'default_lng'                         : '<?php echo esc_html($default_lng); ?>',
        'auto_country'                        : '<?php echo esc_html($auto_country); ?>',
        'geocode_error'                       : '<?php echo __('Geocode was not successful for the following reason', 'resideo'); ?>',
        'marker_label'                        : '<?php echo __('Marker', 'resideo'); ?>',
        'marker_title'                        : '<?php echo __('Map Marker', 'resideo'); ?>',
        'marker_btn'                          : '<?php echo __('Insert Image', 'resideo'); ?>',
        'map_position_label'                  : '<?php echo __('Map Position', 'resideo'); ?>',
        'map_position_right'                  : '<?php echo __('Right', 'resideo'); ?>',
        'map_position_left'                   : '<?php echo __('Left', 'resideo'); ?>',
        'align_label'                         : '<?php echo __('Align', 'resideo'); ?>',
        'align_left'                          : '<?php echo __('Left', 'resideo'); ?>',
        'align_center'                        : '<?php echo __('Center', 'resideo'); ?>',
        'align_right'                         : '<?php echo __('Right', 'resideo'); ?>',
        'promo_title'                         : '<?php echo __('Promo', 'resideo'); ?>',
        'text_label'                          : '<?php echo __('Text', 'resideo'); ?>',
        'text_placeholder'                    : '<?php echo __('Enter text', 'resideo'); ?>',
        'caption_position_label'              : '<?php echo __('Caption Position', 'resideo'); ?>',
        'right_label'                         : '<?php echo __('Right', 'resideo'); ?>',
        'left_label'                          : '<?php echo __('Left', 'resideo'); ?>',
        'media_promo_image_title'             : '<?php echo __('Image', 'resideo'); ?>',
        'media_promo_image_btn'               : '<?php echo __('Insert Image', 'resideo'); ?>',
        'promo_img_label'                     : '<?php echo __('Image', 'resideo'); ?>',
        'text_align_label'                    : '<?php echo __('Text Align', 'resideo'); ?>',
        'layout_label'                        : '<?php echo __('Layout', 'resideo'); ?>',
        'top_left_label'                      : '<?php echo __('Top Left', 'resideo'); ?>',
        'top_right_label'                     : '<?php echo __('Top Right', 'resideo'); ?>',
        'center_left_label'                   : '<?php echo __('Center Left', 'resideo'); ?>',
        'center_label'                        : '<?php echo __('Center', 'resideo'); ?>',
        'center_right_label'                  : '<?php echo __('Center Right', 'resideo'); ?>',
        'bottom_left_label'                   : '<?php echo __('Bottom Left', 'resideo'); ?>',
        'bottom_right_label'                  : '<?php echo __('Bottom Right', 'resideo'); ?>',
        'subscribe_title'                     : '<?php echo __('Subscribe', 'resideo'); ?>',
        'media_subscribe_image_title'         : '<?php echo __('Subscribe Background Image', 'resideo'); ?>',
        'media_subscribe_image_btn'           : '<?php echo __('Insert Image', 'resideo'); ?>',
        'service_cta_color'                   : '<?php echo __('Service CTA Color', 'resideo'); ?>',
        'cta_button_color'                    : '<?php echo __('CTA Button Color', 'resideo'); ?>',
        'area_cta_color'                      : '<?php echo __('Area CTA Color', 'resideo'); ?>',
        'agent_card_cta_color'                : '<?php echo __('Agent Card CTA Color', 'resideo'); ?>',
        'plans_title_color'                   : '<?php echo __('Plans Title Color', 'resideo'); ?>',
        'plans_price_color'                   : '<?php echo __('Plans Price Color', 'resideo'); ?>',
        'plans_cta_color'                     : '<?php echo __('Plans CTA Color', 'resideo'); ?>',
        'featured_plan_title_color'           : '<?php echo __('Featured Plan Title Color', 'resideo'); ?>',
        'featured_plan_price_color'           : '<?php echo __('Featured Plan Price Color', 'resideo'); ?>',
        'featured_plan_cta_color'             : '<?php echo __('Featured Plan CTA Color', 'resideo'); ?>',
        'featured_plan_label_color'           : '<?php echo __('Featured Plan Label Color', 'resideo'); ?>',
        'blog_post_card_cta_color'            : '<?php echo __('Post Card CTA Color', 'resideo'); ?>',
        'gallery_carousel_title'              : '<?php echo __('Gallery Carousel', 'resideo'); ?>',
        'gallery_carousel_photos'             : '<?php echo __('Gallery Carousel Photos', 'resideo'); ?>',
        'add_gallery_carousel_photo_btn'      : '<?php echo __('Add New Photo', 'resideo'); ?>',
        'new_gallery_carousel_photo_header'   : '<?php echo __('New Photo', 'resideo'); ?>',
        'gallery_carousel_photo_add_img'      : '<?php echo __('Add Photo', 'resideo'); ?>',
        'ok_gallery_carousel_photo_btn'       : '<?php echo __('Add', 'resideo'); ?>',
        'cancel_gallery_carousel_photo_btn'   : '<?php echo __('Cancel', 'resideo'); ?>',
        'edit_gallery_carousel_photo_header'  : '<?php echo __('Edit Photo', 'resideo'); ?>',
        'ok_edit_gallery_carousel_photo_btn'  : '<?php echo __('OK', 'resideo'); ?>',
        'gallery_carousel_photo'              : '<?php echo __('Photo', 'resideo'); ?>',
        'gallery_carousel_insert_photo'       : '<?php echo __('Insert Photo', 'resideo'); ?>',
        'numbers_title'                       : '<?php echo __('Numbers', 'resideo'); ?>',
        'numbers_list'                        : '<?php echo __('Numbers List', 'resideo'); ?>',
        'add_number_btn'                      : '<?php echo __('Add New Number', 'resideo'); ?>',
        'new_number_header'                   : '<?php echo __('New Number', 'resideo'); ?>',
        'number_sum_label'                    : '<?php echo __('Number', 'resideo'); ?>',
        'number_sum_placeholder'              : '<?php echo __('Enter number', 'resideo'); ?>',
        'number_sign_label'                   : '<?php echo __('Number sign', 'resideo'); ?>',
        'number_sign_placeholder'             : '<?php echo __('Enter number sign', 'resideo'); ?>',
        'number_delay_label'                  : '<?php echo __('Number animation delay', 'resideo'); ?>',
        'number_delay_placeholder'            : '<?php echo __('Enter number delay', 'resideo'); ?>',
        'number_increment_label'              : '<?php echo __('Number increment', 'resideo'); ?>',
        'number_increment_placeholder'        : '<?php echo __('Enter number increment', 'resideo'); ?>',
        'number_title_label'                  : '<?php echo __('Number Title', 'resideo'); ?>',
        'number_title_placeholder'            : '<?php echo __('Enter number title', 'resideo'); ?>',
        'number_text_label'                   : '<?php echo __('Number Text', 'resideo'); ?>',
        'number_text_placeholder'             : '<?php echo __('Enter number text', 'resideo'); ?>',
        'ok_number_btn'                       : '<?php echo __('Add', 'resideo'); ?>',
        'cancel_number_btn'                   : '<?php echo __('Cancel', 'resideo'); ?>',
        'media_numbers_image_title'           : '<?php echo __('Numbers Background Image', 'resideo'); ?>',
        'media_numbers_image_btn'             : '<?php echo __('Insert Image', 'resideo'); ?>',
        'edit_number_header'                  : '<?php echo __('Edit Number', 'resideo'); ?>',
        'ok_edit_number_btn'                  : '<?php echo __('OK', 'resideo'); ?>',
        'cancel_number_btn'                   : '<?php echo __('Cancel', 'resideo'); ?>',
        'awards_title'                        : '<?php echo __('Awards', 'resideo'); ?>',
        'awards_list'                         : '<?php echo __('Awards List', 'resideo'); ?>',
        'add_award_btn'                       : '<?php echo __('Add New Award', 'resideo'); ?>',
        'new_award_header'                    : '<?php echo __('New Award', 'resideo'); ?>',
        'award_add_img'                       : '<?php echo __('Add Image', 'resideo'); ?>',
        'award_title_label'                   : '<?php echo __('Award Title', 'resideo'); ?>',
        'award_title_placeholder'             : '<?php echo __('Enter award title', 'resideo'); ?>',
        'ok_award_btn'                        : '<?php echo __('Add', 'resideo'); ?>',
        'cancel_award_btn'                    : '<?php echo __('Cancel', 'resideo'); ?>',
        'edit_award_header'                   : '<?php echo __('Edit Award', 'resideo'); ?>',
        'ok_edit_award_btn'                   : '<?php echo __('OK', 'resideo'); ?>',
        'cancel_award_btn'                    : '<?php echo __('Cancel', 'resideo'); ?>',
        'award_image'                         : '<?php echo __('Award Image', 'resideo'); ?>',
        'award_insert_image'                  : '<?php echo __('Insert Image', 'resideo'); ?>',
        'single_property_title'               : '<?php echo __('Single Property', 'resideo'); ?>',
        'single_property_name_label'          : '<?php echo __('Property Name', 'resideo'); ?>',
        'single_property_name_placeholder'    : '<?php echo __('Search for a property...', 'resideo'); ?>',
        'single_property_image_position_label': '<?php echo __('Image Position', 'resideo'); ?>',
        'single_property_list'                : '<?php echo resideo_get_sh_properties(); ?>',
        'hide_agents_phone'                   : '<?php echo esc_html($hide_agents_phone); ?>',
        'search_properties_title'             : '<?php echo __('Search Properties', 'resideo'); ?>',
        'property_custom_fields'              : '<?php echo resideo_get_sh_property_custom_fields(); ?>',
        'slider_promo_title'                  : '<?php echo __('Promo Slider', 'resideo'); ?>',
        'cta_buttons_color'                   : '<?php echo __('CTA Buttons Color', 'resideo'); ?>',
        'promo_slides'                        : '<?php echo __('Slides', 'resideo'); ?>',
        'add_promo_slide_btn'                 : '<?php echo __('Add New Slide', 'resideo'); ?>',
        'new_promo_slide_header'              : '<?php echo __('New Slide', 'resideo'); ?>',
        'promo_slide_add_img'                 : '<?php echo __('Add Image', 'resideo'); ?>',
        'promo_slide_title_label'             : '<?php echo __('Slide Title', 'resideo'); ?>',
        'promo_slide_title_placeholder'       : '<?php echo __('Enter slide title', 'resideo'); ?>',
        'promo_slide_text_label'              : '<?php echo __('Slide Text', 'resideo'); ?>',
        'promo_slide_text_placeholder'        : '<?php echo __('Enter slide text', 'resideo'); ?>',
        'ok_promo_slide_btn'                  : '<?php echo __('Add', 'resideo'); ?>',
        'cancel_promo_slide_btn'              : '<?php echo __('Cancel', 'resideo'); ?>',
        'edit_slide_header'                   : '<?php echo __('Edit Slide', 'resideo'); ?>',
        'ok_edit_promo_slide_btn'             : '<?php echo __('OK', 'resideo'); ?>',
        'cancel_edit_promo_slide_btn'         : '<?php echo __('Cancel', 'resideo'); ?>',
        'slide_image'                         : '<?php echo __('Slide Image', 'resideo'); ?>',
        'slide_insert_image'                  : '<?php echo __('Insert Image', 'resideo'); ?>'
    };
    </script>
    <!-- TinyMCE Shortcode Plugin -->
<?php }

add_action('init', 'resideo_register_shortcodes');

if (!function_exists('resideo_get_types_statuses')): 
    function resideo_get_types_statuses() {
        $type_taxonomies = array( 
            'property_type'
        );
        $type_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $type_terms = get_terms($type_taxonomies, $type_args);

        $status_taxonomies = array( 
            'property_status'
        );
        $status_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $status_terms = get_terms($status_taxonomies, $status_args);

        echo json_encode(array('getts' => true, 'types' => $type_terms, 'statuses' => $status_terms));
        exit();

        die();
    }
endif;
add_action('wp_ajax_nopriv_resideo_get_types_statuses', 'resideo_get_types_statuses');
add_action('wp_ajax_resideo_get_types_statuses', 'resideo_get_types_statuses');
?>
<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

 

add_action('wp_enqueue_scripts', 'resideo_enqueue_styles');
function resideo_enqueue_styles() {
    $parenthandle = 'resideo-style';
    $theme = wp_get_theme();

    wp_enqueue_style($parenthandle, get_template_directory_uri() . '/style.css', 
        array(
            'jquery-ui',
            'fileinput',
            'base-font',
            'font-awesome',
            'bootstrap',
            'datepicker',
            'owl-carousel',
            'owl-theme',
            'photoswipe',
            'photoswipe-skin'
        ), 
        $theme->parent()->get('Version')
    );

    wp_enqueue_style('child-style', get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version')
    );
}
?>
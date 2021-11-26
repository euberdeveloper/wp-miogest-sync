<?php
/*
* Plugin Name: Wp Miogest Sync
* Description: Integration with miogest for automatically synchronize posts
* Text Domain: wp-miogest-sync
* Domain Path: /languages
* Version: 2.0
* Author: s4web
* Author URI: http://s4web.it
*/

function create_plugin_database_table()
{
    global $table_prefix, $wpdb;

    require_once(ABSPATH . '/wp-admin/upgrade-functions.php');

    $tablename = 'miogest_synced_annunci';
    $wp_track_table = $table_prefix . "$tablename";

    // Create the table if it does not exist
    if ($wpdb->get_var("SHOW TABLS LIKE '$wp_track_table'") != $wp_track_table) {

        $sql = "CREATE TABLE $wp_track_table ( 
          `post_id` int(11) NOT NULL, 
          `type` int(2) NOT NULL,
          `annuncio_id` int(11) NOT NULL,
          `lang` CHAR(2) NOT NULL,
          PRIMARY KEY `order_id` (`post_id`, `type`) 
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

        require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
register_activation_hook(__FILE__, 'create_plugin_database_table');

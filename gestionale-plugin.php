<?php
/*
* Plugin Name: Gestionale Plugin
* Description: Integration with miogest for automati sync of post
* Text Domain: gestionale
* Domain Path: /languages
* Version: 2.0
* Author: s4web
* Author URI: http://s4web.it
*/

define('GESTIONALE_PLUGIN_PATH', plugin_dir_url( __FILE__ ));
define('GESTIONALE_PLUGIN_BASENAME', plugin_basename(__FILE__));

function create_plugin_database_table()
{
    global $table_prefix, $wpdb;
	
	require_once(ABSPATH .'/wp-admin/upgrade-functions.php');

    $tblname = 'gestionale';
    $wp_track_table = $table_prefix . "$tblname ";

    #Check to see if the table exists already, if not, then create it

    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 
    {

        $sql = "CREATE TABLE ". $wp_track_table . " ( ";
        $sql .= "  `id`  int(11)   NOT NULL, ";
        $sql .= "  `type`  int(2)   NOT NULL, ";
        $sql .= "  PRIMARY KEY  `order_id` (`id`, `type`) "; 
        $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
        require_once(ABSPATH .'/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
		
    }
}

 register_activation_hook( __FILE__, 'create_plugin_database_table' );


?>
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

require_once __DIR__ . '/src/autoload.php';

use WpMiogestSync\Utils\Logger;
use WpMiogestSync\Modules\Syncer;

function create_plugin_database_table()
{
  Logger::$logger->info('Initializing plugin');
  $syncer = new Syncer();
  $syncer->createTableIfNotExists();
  Logger::$logger->info('Plugin initialized');
}
register_activation_hook(__FILE__, 'create_plugin_database_table');

function uninstall_and_remove_everything()
{
  Logger::$logger->info('Uninstalling plugin');
  $syncer = new Syncer();
  $syncer->getAnnunciIds();
  $syncer->deleteOldAnnunci();
  $syncer->deleteOldAnnunciThumbs();
  Logger::$logger->info('Plugin uninstalled');
}
register_uninstall_hook(__FILE__, 'uninstall_and_remove_everything');

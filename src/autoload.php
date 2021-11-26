<?php

declare(strict_types=1);

// Require wordpress stuff

require_once(WP_MIOGEST_SYNC_WORDPRESS_DIR . '/wp-load.php');
require_once(WP_MIOGEST_SYNC_WORDPRESS_DIR . '/wp-admin/includes/upgrade.php');
require_once(WP_MIOGEST_SYNC_WORDPRESS_DIR . '/wp-admin/upgrade-functions.php');
require_once(WP_MIOGEST_SYNC_WORDPRESS_DIR . '/wp-admin/includes/image.php');

// Load vendor libs

require_once(WP_MIOGEST_SYNC_PLUGIN_DIR .'/vendor/autoload.php');

// Polyfills

require_once(WP_MIOGEST_SYNC_PLUGIN_DIR .'/src/polyfills/polyfills.php');


// Load utils and moudles

require_once(WP_MIOGEST_SYNC_PLUGIN_DIR .'/src/utils/Logger.php');
require_once(WP_MIOGEST_SYNC_PLUGIN_DIR .'/src/utils/EraseThumbnails.php');
require_once(WP_MIOGEST_SYNC_PLUGIN_DIR .'/src/modules/syncer.php');


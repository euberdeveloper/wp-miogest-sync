<?php

declare(strict_types=1);

// Require wordpress stuff

require_once('../../../wp-load.php');
require_once('../../../wp-admin/includes/upgrade.php');
require_once('../../../wp-admin/includes/image.php');

// Load vendor libs

require_once('vendor/autoload.php');

// Polyfills

require_once('src/polyfills/polyfills.php');


// Load utils and moudles

require_once('src/utils/Logger.php');
require_once('src/utils/EraseThumbnails.php');
require_once('src/modules/syncer.php');


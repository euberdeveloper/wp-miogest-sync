<?php

require_once __DIR__ . '/src/autoload.php';

use WpMiogestSync\Utils\Logger;
use WpMiogestSync\Modules\Syncer;

Logger::$logger->info('Initializing syncer');
$syncer = new Syncer();
Logger::$logger->info('Check that the call was made by an allowed address');
$syncer->checkRemoteAddress();
Logger::$logger->info('Fetching data from remote addresses');
$syncer->fetchRemoteData();
Logger::$logger->info('Get all the ids from the annunci table');
$syncer->getAnnunciIds();
Logger::$logger->info('Delete old annunci\'s data');
$syncer->deleteOldAnnunci();
Logger::$logger->info('Insert new annunci');
$syncer->insertNewAnnunci();
Logger::$logger->info('Sync complete');

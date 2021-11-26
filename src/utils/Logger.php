<?php

namespace WpMiogestSync\Utils;

use Monolog;

$__wp_miogest_sync_logger = new Monolog\Logger('wp-miogest-sync');
$__wp_miogest_sync_logger->pushHandler(new Monolog\Handler\StreamHandler('wp-miogest-sync.log'));

class Logger {
    public static ?Monolog\Logger $logger = null;
}
Logger::$logger = $__wp_miogest_sync_logger;

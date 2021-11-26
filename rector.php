<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\Set\ValueObject\DowngradeSetList;

define('WP_MIOGEST_SYNC_WORDPRESS_DIR', '../../..');
define('WP_MIOGEST_SYNC_PLUGIN_DIR', WP_MIOGEST_SYNC_WORDPRESS_DIR . '/wp-content/plugins/wp-miogest-sync');

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/wp-miogest-sync.php',
        __DIR__ . '/sync.php'
    ]);
    $parameters->set(Option::BOOTSTRAP_FILES, [
        __DIR__ . '/src/autoload.php',
    ]);

    $containerConfigurator->import(DowngradeSetList::PHP_53);
    $containerConfigurator->import(DowngradeSetList::PHP_70);
    $containerConfigurator->import(DowngradeSetList::PHP_71);
    $containerConfigurator->import(DowngradeSetList::PHP_72);
    $containerConfigurator->import(DowngradeSetList::PHP_73);
    $containerConfigurator->import(DowngradeSetList::PHP_74);
    $containerConfigurator->import(DowngradeSetList::PHP_80);
};

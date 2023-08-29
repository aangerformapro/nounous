<?php
/**
 * App Environment.
 */
declare(strict_types=1);

use Dotenv\Dotenv;
use NGSOFT\Facades\Container;
use Roots\WPConfig\Config;

use function Env\env;
use function NGSOFT\Filesystem\require_file;

$rootPath = dirname(__DIR__);

/**
 * Load composer.
 */
require_once $rootPath . '/vendor/autoload.php';

$envFiles = [];

foreach (['.env', '.env.local'] as $file)
{
    if (is_file($rootPath . DIRECTORY_SEPARATOR . $file))
    {
        $envFiles[] = $file;
    }
}

if (count($envFiles) > 0)
{
    $dotEnv = Dotenv::createUnsafeImmutable($rootPath, $envFiles, false);
    $dotEnv->load();

    if ( ! env('DATABASE_URL'))
    {
        $dotEnv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD']);
    }
}

Config::define('APP_PATH', __DIR__);
Config::define('ROOT_PATH', $rootPath);
Config::define('TEMPLATE_PATH', $rootPath . DIRECTORY_SEPARATOR . 'templates');
Config::define('LOG_PATH', $rootPath . DIRECTORY_SEPARATOR . 'logs');
Config::define('DB_NAME', env('DB_NAME'));
Config::define('DB_USER', env('DB_USER'));
Config::define('DB_PASSWORD', env('DB_PASSWORD'));
Config::define('DB_HOST', env('DB_HOST') ?: 'localhost');
Config::define('DB_PORT', env('DB_PORT') ?: 3306);
Config::define('DB_CHARSET', 'utf8mb4');
Config::define('DB_COLLATE', 'utf8mb4_general_ci');
Config::define('TZ_ID', env('TZ_ID') ?: 'Europe/Paris');
Config::define('SITE_NAME', env('SITE_NAME') ?: 'My New Website');
Config::apply();

date_default_timezone_set(Config::get('TZ_ID'));

\Carbon\Carbon::setLocale('fr');

// (require_file(__DIR__ . '/settings.php'))(Container::getFacadeRoot());
(require_file(__DIR__ . '/dependencies.php'))(Container::getFacadeRoot());

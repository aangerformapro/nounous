<?php

declare(strict_types=1);

use voku\helper\AntiXSS;

require_once __DIR__ . '/constants.php';

function loadView(string $view, array $data = []): string
{
    ob_start();

    $cwd  = getcwd();

    if ( ! str_ends_with($view, '.php'))
    {
        $view .= '.php';
    }

    $file = TEMPLATES . DIRECTORY_SEPARATOR . $view;

    if (is_file(filename: $file))
    {
        if (@chdir(dirname($file)))
        {
            call_user_func(function ()
            {
                extract(func_get_arg(0));

                include func_get_arg(1);
            }, $data, $file);

            @chdir($cwd);
        }
    } else
    {
        throw new RuntimeException('View ' . func_get_arg(0) . ' not found in ' . TEMPLATES, 1);
    }

    return ob_get_clean() ?: '';
}

function formatTime(DateTime $date): string
{
    return $date->format('Y-m-d') . 'T' . $date->format('H:i');
}

function formatTimeSQL(DateTime $date): string
{
    return $date->format('Y-m-d G:i:s');
}

function formatDateSQL(DateTime $date): string
{
    return $date->format('Y-m-d');
}

/**
 * @return string|string[]
 */
function getPostdata(string ...$keys)
{
    static $xss;
    $xss ??= new AntiXSS();

    $values = [];

    if ( ! count($keys))
    {
        $keys = array_keys($_POST);
    }

    foreach ($keys as $key)
    {
        if ( ! isset($_POST[$key]))
        {
            $values[$key] = null;
            continue;
        }
        $values[$key] = $xss->xss_clean($_POST[$key]);
    }

    if (1 === count($keys))
    {
        return $values[$keys[0]];
    }

    return $values;
}

function isExpired(string $date)
{
    return date_create('now')->getTimestamp() > date_create($date)->getTimestamp();
}

function getRequestMethod(): string
{
    return $_SERVER['REQUEST_METHOD'] ?? 'GET';
}

function isSecurePassword(string $password)
{
    foreach ([
        '/[\$\&\+\,\:\;\=\?\@\#\|\<\>\.\^\*\(\)\%\!\-\}\{\[\]]/',
        '/[A-Z]/', '/[a-z]/', '/\d/',

    ] as $pattern)
    {
        if ( ! preg_match($pattern, $password))
        {
            return false;
        }
    }

    return mb_strlen($password) >= 8;
}

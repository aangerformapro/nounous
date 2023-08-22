<?php

declare(strict_types=1);

use Models\User;
use Models\UserType;
use NGSOFT\Facades\Container;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Interfaces\RouteParserInterface;

require_once __DIR__ . '/constants.php';

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

function isExpired(string $date)
{
    return date_create('now')->getTimestamp() > date_create($date)->getTimestamp();
}

function formatDateTimeInput(DateTime $date): string
{
    return $date->format(FORMAT_DATE_INPUT) . 'T' . $date->format(FORMAT_TIME_INPUT);
}

function formatDateInput(DateTime $date): string
{
    return $date->format(FORMAT_DATE_INPUT);
}

function formatTimeInput(DateTime $date): string
{
    return $date->format(FORMAT_TIME_INPUT);
}

function formatDateTimeSQL(DateTime $date): string
{
    return $date->format(FORMAT_DATETIME_SQL);
}

function formatDateSQL(DateTime $date): string
{
    return $date->format(FORMAT_DATE_SQL);
}

function formatTimeSQL(DateTime $date): string
{
    return $date->format(FORMAT_TIME_SQL);
}

function urlFor(string $routeName, array $data = [], array $queryParams = []): string
{
    static $routeParser;
    $routeParser ??= Container::get(RouteParserInterface::class);
    return $routeParser->urlFor($routeName, $data, $queryParams);
}

function isCurrentRoute(string $routeName, array $data = []): bool
{
    static $request, $routeParser;
    $request     ??= ServerRequestCreatorFactory::create()->createServerRequestFromGlobals();
    $routeParser ??= Container::get(RouteParserInterface::class);

    $currentUrl = $request->getUri()->getPath();
    $result     = $routeParser->urlFor($routeName, $data);
    return $result === $currentUrl;
}

function isLoggedIn(): bool
{
    return Container::has('user');
}

function isBabySitter(): bool
{
    /** @var User $user */
    $user = Container::get('user');
    return UserType::BABYSITTER === $user->getType();
}

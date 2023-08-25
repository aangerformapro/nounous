<?php

declare(strict_types=1);

namespace App\Facades;

use NGSOFT\Container\Container;
use NGSOFT\Container\ServiceProvider;
use NGSOFT\Container\SimpleServiceProvider;
use NGSOFT\DataStructure\Collection;
use NGSOFT\Facades\Facade;
use Roots\WPConfig\Config;

class Settings extends Facade
{
    public static function get(string $name, mixed $defaultValue = null): mixed
    {
        $segments = explode('.', $name);

        $obj      = static::getFacadeRoot();

        while ($segment = array_shift($segments))
        {
            $obj = $obj[$segment];

            if (false === $obj instanceof Collection && count($segments))
            {
                $obj = null;
                break;
            }
        }

        return $obj ?? value($defaultValue);
    }

    public static function addAttribute(string $name, mixed $value): void
    {
        $attributes = static::get('attributes');

        if ( ! isset($attributes[$name]))
        {
            static::setAttribute($name, $value);
        }
    }

    public static function addAttributes(array $attributes): void
    {
        foreach ($attributes as $key => $value)
        {
            static::addAttribute($key, $value);
        }
    }

    public static function setAttribute(string $name, mixed $value): void
    {
        $segments   = explode('.', $name);

        $attributes = static::get('attributes');

        while ($segment = array_shift($segments))
        {
            if ( ! count($segments))
            {
                $attributes[$segment] = value($value);
            } else
            {
                if ($attributes[$segment] instanceof Collection === false)
                {
                    $attributes[$segment] = [];
                }
                $attributes = $attributes[$segment];
            }
        }
    }

    public static function removeAttribute(string $name): void
    {
        $attributes = static::get('attributes');
        unset($attributes[$name]);
    }

    public static function getAttribute(string $name, mixed $defaultValue = null): mixed
    {
        $attributes = static::get('attributes');
        return $attributes[$name] ?? value($defaultValue);
    }

    protected static function getFacadeAccessor(): string
    {
        return static::getAlias();
    }

    protected static function getServiceProvider(): ServiceProvider
    {
        return new SimpleServiceProvider(static::getFacadeAccessor(), function (Container $container)
        {
            $container->set(
                static::getFacadeAccessor(),
                \App\Application\Settings::loadSettings(
                    Config::get('ROOT_PATH')
                )
            );
        });
    }
}

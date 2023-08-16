<?php

namespace Model;

use NGSOFT\Facades\Container;
use Roots\WPConfig\Config;

abstract class BaseModel
{
    /**
     * Table name.
     */
    abstract public static function getTable(): string;

    /**
     * Entry point.
     */
    public static function getConnection(): \PDO
    {
        return Container::get(\PDO::class);
    }

    /**
     * Table creation query.
     */
    abstract protected static function tableCreate();

    protected static function getCharset(): string
    {
        return Config::get('DB_CHARSET');
    }

    protected static function getCollate(): string
    {
        return Config::get('DB_COLLATE');
    }
}

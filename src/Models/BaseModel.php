<?php

namespace Model;

use NGSOFT\Facades\Container;

abstract class BaseModel
{
    /**
     * Entry point.
     */
    public static function getConnection(): \PDO
    {
        return Container::get(\PDO::class);
    }

    abstract public static function getTable(): string;

    public static function find(string $where = '1', array $bindings = []): array
    {
        $stmt = static::getConnection()->prepare(
            sprintf('SELECT * FROM %s WHERE %s', static::getTable(), $where)
        );

        if ($stmt->execute($bindings))
        {
            return array_map(fn ($data) => new static($data), $stmt->fetchAll(\PDO::FETCH_ASSOC));
        }

        return [];
    }
}

<?php

namespace Models;

use NGSOFT\Facades\Container;

use function NGSOFT\Tools\map;

abstract class BaseModel
{
    protected int $id;

    public function __construct(array $data = [])
    {
    }

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

    public static function describe()
    {
        $stmt   = static::getConnection()->query(sprintf('DESCRIBE %s', static::getTable()));
        $result = [];

        foreach ($stmt->fetchAll() as $item)
        {
            $result[$item['Field']] = map(function ($value, &$key)
            {
                $key = strtolower($key);
                return $value;
            }, $item);
        }
        return $result;
    }

   public static function findById(int|string $id): ?static
   {
       return static::findOne('id = ?', [$id]);
   }

    public static function findOne(string $where = '1', array $bindings = []): ?static
    {
        $stmt = static::getConnection()->prepare(
            sprintf('SELECT * FROM %s WHERE %s', static::getTable(), $where)
        );

        if ($stmt->execute($bindings))
        {
            return new static($stmt->fetch(\PDO::FETCH_ASSOC));
        }

        return null;
    }

    /**
     * Get the value of id.
     */
    public function getId()
    {
        return $this->id;
    }
}

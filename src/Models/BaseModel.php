<?php

declare(strict_types=1);

namespace Models;

use NGSOFT\Facades\Container;

use function NGSOFT\Tools\map;

abstract class BaseModel
{
    protected int $id;

    abstract public function __construct(array $data = []);

    /**
     * Entry point.
     */
    public static function getConnection(): \PDO
    {
        return Container::get(\PDO::class);
    }

    abstract public static function getTable(): string;

    public static function find(string $where = '', array $bindings = []): array
    {
        if (!empty($where))
        {
            $where = sprintf(' WHERE %s', $where);
        }
        $stmt = static::getConnection()->prepare(
            sprintf('SELECT * FROM %s%s', static::getTable(), $where)
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

    public static function findOne(string $where = '', array $bindings = []): ?static
    {
        if (!empty($where))
        {
            $where = sprintf(' WHERE %s', $where);
        }

        $stmt = static::getConnection()->prepare(
            sprintf('SELECT * FROM %s%s', static::getTable(), $where)
        );

        if ($stmt->execute($bindings))
        {
            if (is_array($data = $stmt->fetch(\PDO::FETCH_ASSOC)))
            {
                return new static($data);
            }
        }

        return null;
    }

    public static function removeEntry(self $model)
    {
        $stmt = static::getConnection()->prepare(
            sprintf(
                'DELETE FROM %s WHERE id = ?',
                static::getTable()
            )
        );

        return $stmt->execute([$model->getId()]);
    }

    public static function updateEntry(self|int|string $id, array $data): ?static
    {
        if (is_object($id) && is_a($id, static::class))
        {
            $id = $id->getId();
        }

        $newdata = $values = [];

        foreach ($data as $key => $value)
        {
            if (property_exists(static::class, $key))
            {
                if ('id' === $key)
                {
                    continue;
                }
                $newdata[$key] = $value;
                $values[]      = sprintf('%s = :%s', $key, $key);
            }
        }

        if ( ! empty($values))
        {
            static::getConnection()->prepare(
                sprintf(
                    'UPDATE %s SET %s WHERE id = :id',
                    static::getTable(),
                    implode(', ', $values)
                )
            )->execute($newdata + ['id' => $id]);

            return static::findById($id);
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

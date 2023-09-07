<?php

declare(strict_types=1);

namespace Models;

class AvailableAppointments
{
    // id sur availabilities
    protected int $id;

    protected User $nounou;

    protected int $nounou_id;

    protected string $start;
    protected string $end;
    protected string $date;
    protected float $hourly_rate;

    // appointments

    protected int $id_appointment;

    protected null|int $enfant_id = null;
    protected null|Enfant $enfant = null;
    protected Status $status;
    protected bool $valid;

    public function __construct(array $data = [])
    {
        $this->id             = (int) $data['id'];

        $this->id_appointment = (int) $data['id_appointment'];
        $this->nounou_id      = (int) $data['id_nounou'];
        $this->nounou         = User::findById($data['id_nounou']);
        $this->start          = $data['start'];
        $this->end            = $data['end'];
        $this->date           = $data['date'];
        $this->hourly_rate    = (float) $data['hourly_rate'];

        $this->status         = Status::from($data['status']);
        $this->valid          = (bool) $data['valid'];

        if ( ! is_null($data['id_enfant']))
        {
            $this->enfant    = Enfant::findById($data['id_enfant']);
            $this->enfant_id = (int) $data['id_enfant'];
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNounou(): User
    {
        return $this->nounou;
    }

    public function getStart(bool $asString = false): string|\DateTimeInterface
    {
        return
            $asString ?
                $this->start :
                date_create_from_format(
                    FORMAT_TIME_SQL,
                    $this->start
                );
    }

    public function getEnd(bool $asString = false): string|\DateTimeInterface
    {
        return
            $asString ?
                $this->end :
            date_create_from_format(
                FORMAT_TIME_SQL,
                $this->end
            );
    }

    public function getDate(bool $asString = false): \DateTimeInterface|string
    {
        return $asString ?
            $this->date :
            date_create_from_format(
                FORMAT_DATE_SQL,
                $this->date
            );
    }

    public function getHourlyRate(): float
    {
        return $this->hourly_rate;
    }

    public function getIdAppointment(): int
    {
        return $this->id_appointment;
    }

    public function getNounouId(): int
    {
        return $this->nounou_id;
    }

    public function getEnfantId(): ?int
    {
        return $this->enfant_id;
    }

    public function getEnfant(): ?Enfant
    {
        return $this->enfant;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getValid(): bool
    {
        return $this->valid;
    }

    public static function find(string $where = '', array $bindings = []): array
    {
        $stmt = BaseModel::getConnection()->prepare(
            static::getSelect() . (
                ! empty($where) ?
                    sprintf(' WHERE %s', $where) :
                    ''
            )
        );

        if ($stmt->execute($bindings))
        {
            if ($data = $stmt->fetchAll(\PDO::FETCH_ASSOC))
            {
                return array_map(fn ($entry) => new static($entry), $data);
            }
        }
        return [];
    }

    public static function findForParents(User $parent, string $where = '', array $bindings = []): array
    {
        $children   = $parent->getChildren();

        if ( ! count($children))
        {
            return [];
        }

        $idChildren = array_map(fn ($item) => $item->getId(), $children);

        if ( ! empty($where))
        {
            $where = ' AND ' . $where;
        }

        $bindings   = array_merge([
            implode(', ', $idChildren),
        ], $bindings);

        return static::find(
            'id_enfant IN (?)' . $where,
            $bindings
        );
    }

    protected static function getSelect(): string
    {
        return implode(
            ' ',
            [
                'SELECT `availabilities`.*, `appointments`.`id` AS `id_appointment`, `appointments`.`id_enfant`, `appointments`.`status`, `appointments`.`valid`',
                'FROM `availabilities`',
                'INNER JOIN `appointments` ON `appointments`.`id_availability` = `availabilities`.`id`',
            ]
        );
    }
}

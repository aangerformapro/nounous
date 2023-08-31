<?php

declare(strict_types=1);

namespace Models;

class Availability extends BaseModel implements \Countable
{
    protected int $id_nounou;
    protected \DateTime $start;
    protected \DateTime $end;

    protected float $hourly_rate;

    protected \DateTime $date;

    public function __construct(array $data = [])
    {
        $this->id          = (int) $data['id'];

        $this->id_nounou   = (int) $data['id_nounou'];
        $this->hourly_rate = $data['hourly_rate'];
        $this->date        = date_create_from_format('Y-m-d', $data['date']);
        $this->start       = date_create_from_format('G:i:s', $data['start']);
        $this->end         = date_create_from_format('G:i:s', $data['end']);
    }

    public static function findPendingAvailabilities(): array
    {
        $stmt = static::getConnection()->prepare(
            'SELECT * FROM %s INNER JOIN id_nounou on %s.id',
            static::getTable(),
            User::getTable()
        );

        return [];
    }

    public static function addAvailability(User $nounou, array $data, int $slots = 1): ?self
    {
        $data['id_nounou'] = $nounou->getId();
        $data['start']     = formatTimeSQL(date_create_from_format(FORMAT_TIME_INPUT, $data['start']));
        $data['end']       = formatTimeSQL(date_create_from_format(FORMAT_TIME_INPUT, $data['end']));
        $data['date']      = formatDateSQL(date_create_from_format(FORMAT_DATE_INPUT, $data['date']));

        $stmt              = static::getConnection()->prepare(
            sprintf(
                'INSERT INTO %s (id_nounou, start, end, date, hourly_rate) ' .
                'VALUES (:id_nounou, :start, :end, :date, :hourly_rate)',
                static::getTable()
            )
        );

        if ($stmt->execute($data))
        {
            $result = static::findById(static::getConnection()->lastInsertId());

            while ($slots > 0)
            {
                Appointment::addAppointment($result);
                --$slots;
            }

            return $result;
        }

        return null;
    }

    public static function getTable(): string
    {
        return 'availabilities';
    }

    public function getAppointments(): array
    {
        return Appointment::find('id_availability = ?', [$this->id]);
    }

    public function getNounou(): ? User
    {
        return User::findOne('id = ?', [$this->id_nounou]);
    }

    /**
     * Get the value of id_nounou.
     */
    public function getIdNounou()
    {
        return $this->id_nounou;
    }

    /**
     * Get the value of start.
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the value of end.
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get the value of hourly_rate.
     */
    public function getHourly_rate()
    {
        return $this->hourly_rate;
    }

    /**
     * Get the value of date.
     */
    public function getDate()
    {
        return $this->date;
    }

    public function count(): int
    {
        return count($this->getAppointments());
    }
}

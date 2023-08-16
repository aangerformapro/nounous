<?php

namespace Models;

class Availabilities extends BaseModel
{
    protected int $id_nounou;
    protected \DateTime $start;
    protected \DateTime $end;

    protected float $hourly_rate;

    protected \DateTime $date;

    public function __construct(array $data = [])
    {
        $this->id          = $data['id'];
        $this->hourly_rate = $data['hourly_rate'];
        $this->date        = date_create_from_format('Y-m-d', $data['date']);
        $this->start       = date_create_from_format('G:i:s', $data['start']);
        $this->end         = date_create_from_format('G:i:s', $data['end']);
    }

    public static function getTable(): string
    {
        return 'availabilities';
    }

    public function getNounou(): User
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
}

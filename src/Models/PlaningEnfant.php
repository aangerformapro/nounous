<?php

namespace Models;

class PlaningEnfant extends BaseModel
{
    protected int $id_enfant;

    protected \DateTime $start;
    protected \DateTime $end;

    public function __construct(array $data = [])
    {
        $this->id        = (int) $data['id'];
        $this->id_enfant = (int) $data['id_enfant'];

        $this->start     = date_create_from_format('Y-m-d G:i:s', $data['start']);
        $this->end       = date_create_from_format('Y-m-d G:i:s', $data['end']);
    }

    public static function getTable(): string
    {
        return 'planing_enfants';
    }

    /**
     * Get the value of id_enfant.
     */
    public function getIdEnfant()
    {
        return $this->id_enfant;
    }

    public function getEnfant(): Enfant
    {
        return Enfant::findOne('id = ?', [$this->id_enfant]);
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
}

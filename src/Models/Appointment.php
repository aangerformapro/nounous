<?php

namespace Models;

class Appointment extends BaseModel
{
    protected null|int $id_enfant = null;

    protected int $id_availability;
    protected Status $status;

    public function __construct(array $data = [])
    {
        $this->id              = (int) $data['id'];

        if (isset($data['id_enfant']))
        {
            $this->id_enfant = $data['id_enfant'];
        }

        $this->id_availability = $data['id_availability'];
        $this->status          = Status::from($data['status']);
    }

    public static function getTable(): string
    {
        return 'appointments';
    }

    /**
     * Get the value of id_enfant.
     */
    public function getIdEnfant()
    {
        return $this->id_enfant;
    }

    public function getEnfant(): ?Enfant
    {
        if (isset($this->id_enfant))
        {
            return Enfant::findOne('id = ?', [$this->id_enfant]);
        }

        return null;
    }

    public function getAvailability(): ?Availability
    {
        return Availability::findOne('id = ?', [$this->id_availability]);
    }

    /**
     * Get the value of id_availability.
     */
    public function getIdAvailability()
    {
        return $this->id_availability;
    }

    /**
     * Get the value of status.
     */
    public function getStatus()
    {
        return $this->status;
    }
}

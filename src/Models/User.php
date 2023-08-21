<?php

namespace Models;

class User extends BaseModel
{
    protected string $email;
    protected string $nom;
    protected string $prenom;
    protected string $address;
    protected string $zip;
    protected string $city;
    protected string $phone;
    protected \DateTime $created_at;
    protected \DateTime $updated_at;

    protected Gender $gender;

    protected UserType $type;

    public function __construct(array $data = [])
    {
        $this->id         = (int) ($data['id'] ?? 0);
        $this->email      = $data['email'];
        $this->nom        = $data['nom'];
        $this->prenom     = $data['prenom'];
        $this->address    = $data['address'];
        $this->zip        = $data['zip'];
        $this->city       = $data['city'];
        $this->phone      = $data['phone'];
        $this->created_at = date_create_from_format('Y-m-d G:i:s', $data['created_at']);
        $this->updated_at = date_create_from_format('Y-m-d G:i:s', $data['updated_at']);
        $this->gender     = Gender::from($data['gender']);
        $this->type       = UserType::from($data['type']);
    }

    public static function getTable(): string
    {
        return 'users';
    }

    public static function connectUser(string $email, string $password): ?static
    {
        $stmt = static::getConnection()->prepare(
            'SELECT * FROM users WHERE email=?'
        );

        if ($stmt->execute([$email]))
        {
            if ($user = $stmt->fetch(\PDO::FETCH_ASSOC))
            {
                if (password_verify($password, $user['password']))
                {
                    return new static($user);
                }
            }
        }

        return null;
    }

    public static function createUser(array $data): bool
    {
        $data['password']   = password_hash($data['password'], PASSWORD_DEFAULT);

        $data['created_at'] = $data['updated_at'] = formatDateTimeSQL(date_create('now'));

        if ($data['type'] instanceof UserType)
        {
            $data['type'] = $data['type']->value;
        }

        if ($data['gender'] instanceof Gender)
        {
            $data['gender'] = $data['gender']->value;
        }

        $stmt               = static::getConnection()->prepare(
            'INSERT INTO users (email, nom, prenom, address, zip, city, phone, gender, type, password, created_at, updated_at) ' .
            'VALUES(:email, :nom, :prenom, :address, :zip, :city, :phone, :gender, :type, :password, :created_at, :updated_at)'
        );

        try
        {
            return $stmt->execute($data);
        } catch (\Throwable $e)
        {
            return false;
        }
    }

    public static function hasUser(int $id = null): bool
    {
        $query = 'SELECT COUNT(id) AS count FROM ' . static::getTable();

        if ( ! is_null($id))
        {
            $query .= ' WHERE id=:id';
            $stmt = static::getConnection()->prepare($query);
            $stmt->bindValue(':id', $id);
        } else
        {
            $stmt = static::getConnection()->prepare($query);
        }

        $stmt->execute();

        if ($result = $stmt->fetch())
        {
            return $result['count'] > 0;
        }

        return false;
    }

    /**
     * Get the value of email.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of nom.
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get the value of prenom.
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Get the value of zip.
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Get the value of city.
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the value of phone.
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the value of created_at.
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at.
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Get the value of sex.
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get the value of type.
     */
    public function getType()
    {
        return $this->type;
    }
}

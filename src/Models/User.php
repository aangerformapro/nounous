<?php

namespace Models;

class User extends BaseModel
{
    protected ?int $id;
    protected string $email;
    protected string $nom;
    protected string $prenom;
    protected string $address;
    protected string $zip;
    protected string $city;
    protected string $phone;
    protected \DateTime $created_at;
    protected \DateTime $updated_at;

    protected Gender $sex;

    protected UserType $type;

    public function __construct(array $data = [])
    {
        $this->id         = (int) ($data['id'] ?? 0);
        $this->email      = $data['email']   ?? '';
        $this->nom        = $data['nom']     ?? '';
        $this->prenom     = $data['prenom']  ?? '';
        $this->address    = $data['address'] ?? '';
        $this->zip        = $data['zip']     ?? '';
        $this->city       = $data['city']    ?? '';
        $this->phone      = $data['phone']   ?? '';
        $this->created_at = date_create($data['created_at'] ?? 'now');
        $this->updated_at = date_create($data['updated_at'] ?? 'now');
        $this->sex        = Gender::from($data['sex']);
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

        if ($data['sex'] instanceof Gender)
        {
            $data['sex'] = $data['sex']->value;
        }

        $stmt               = static::getConnection()->prepare(
            'INSERT INTO users (email, nom, prenom, address, zip, city, phone, sex, type, created_at, updated_at) ' .
            'VALUES(:email, :nom, :prenom, :address, :zip, :city, :phone, :sex, :type, :created_at, :updated_at)'
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
}
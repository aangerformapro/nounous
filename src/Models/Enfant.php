<?php

namespace Models;

class Enfant extends BaseModel
{
    protected int $id_parent;
    protected string $nom;
    protected string $prenom;

    protected \DateTime $birthday;

    public function __construct(array $data = [])
    {
        $this->id        = (int) $data['id'];
        $this->id_parent = (int) $data['id_parent'];
        $this->nom       = $data['nom'];
        $this->prenom    = $data['prenom'];
        $this->birthday  = date_create_from_format('Y-m-d', $data['birthday']);
    }

    public static function getTable(): string
    {
        return 'enfants';
    }

    public function getParent(): User
    {
        return User::findOne('id = ?', [$this->id_parent]);
    }

    /**
     * Get the value of id_parent.
     */
    public function getIdParent()
    {
        return $this->id_parent;
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
     * Get the value of birthday.
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getAge(): int
    {
        return max(1, date_diff(
            $this->getBirthday(),
            date_create('now')
        )->y);
    }

    public static function generateChild(User $parent, array $data)
    {
        $data['id_parent'] = $parent->getId();

        if ($data['birthday'] instanceof \DateTime)
        {
            $data['birthday'] = formatDateSQL($data['birthday']);
        }

        $stmt              = static::getConnection()->prepare(
            sprintf(
                'INSERT INTO %s (id_parent, nom, prenom, birthday) VALUES(:id_parent, :nom, :prenom, :birthday)',
                static::getTable()
            )
        );

        return $stmt->execute($data);
    }

    public static function validateData(array $params, &$errors): array
    {
        $errors = $result = [];

        if (empty($params['nom']))
        {
            $errors[] = 'nom';
        }

        if (empty($params['prenom']))
        {
            $errors[] = 'prenom';
        }

        if (
            empty($params['birthday'])
             || (date_create('now')->getTimestamp() < date_create_from_format(FORMAT_DATE_INPUT, $params['birthday'])->getTimestamp())
             || (date_diff(
                 date_create_from_format(FORMAT_DATE_INPUT, $params['birthday']),
                 date_create('now')
             )->y >= 15)
        ) {
            $errors[] = 'birthday';
        }

        foreach (
            [
                'nom',
                'prenom',
                'birthday',
            ] as $key
        ) {
            if ( ! in_array($key, $errors))
            {
                $result[$key] = $params[$key];
            }
        }
        return $result;
    }
}

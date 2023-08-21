<?php

namespace Models;

class Session extends BaseModel
{
    protected int $id;
    protected int $id_user;

    protected string $session;

    protected \DateTime $expires;

    public function __construct(array $data = [])
    {
        $this->id      = (int) $data['id'];
        $this->id_user = (int) $data['id_user'];
        $this->session = $data['session'];
        $this->expires = date_create_from_format(FORMAT_DATETIME_SQL, $data['expires']);
    }

    public function getUser(): ?User
    {
        return User::findById($this->id_user);
    }

    /**
     * Get the value of id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of session.
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Get the value of id_user.
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    public static function createSession(User $user): ?static
    {
        $stmt = static::getConnection()->prepare(
            sprintf(
                'INSERT INTO %s (id_user, session, expires) VALUES (:id_user, :session, :expires)',
                static::getTable()
            )
        );

        if ($stmt->execute([
            'id_user' => $user->getId(),
            'session' => sha1(uniqid(more_entropy: true)),
            'expires' => date(FORMAT_DATETIME_SQL, strtotime('+7 days')),
        ]))
        {
            return static::findById(static::getConnection()->lastInsertId());
        }
    }

    public static function loadSession(string $session): ?static
    {
        return static::findOne('session = ? AND expires > NOW()', [$session]);
    }

    public static function removeSession(string $session)
    {
        $stmt = static::getConnection()->prepare(
            sprintf(
                'DELETE FROM %s WHERE session = ?',
                static::getTable()
            )
        );
        return $stmt->execute([$session]);
    }

    public static function cleanUp()
    {
        static::getConnection()->query(
            sprintf(
                'DELETE FROM %s WHERE expire < NOW()',
                static::getTable()
            )
        );
    }

    public static function getTable(): string
    {
        return 'sessions';
    }

    public function getExpires(): \DateTime
    {
        return $this->expires;
    }
}

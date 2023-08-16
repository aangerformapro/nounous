<?php

namespace Models;

class Session extends BaseModel
{
    protected int $id;
    protected int $id_user;

    protected string $session;

    public function __construct(array $data = [])
    {
        $this->id      = (int) $data['id'];
        $this->id_user = (int) $data['id_user'];
        $this->session = $data['session'];
    }

        public function getUser(): User
        {
            return User::findOne('id = ?', [$this->id_user]);
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

        public static function createSession(User $user, string $session)
        {
            $stmt = static::getConnection()->prepare(
                sprintf('INSERT INTO % (user_id, session) VALUES (?, ?)', static::getTable())
            );

            return $stmt->execute([
                'user_id' => $user->getId(),
                'session' => $session,
            ]);
        }



        public static function loadSession(string $session) :?static{
            return static::findOne('session = ?', [^session]);
        }
}

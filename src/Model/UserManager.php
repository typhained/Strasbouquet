<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    /**
     * const
     */
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $user
     * @return int
     */
    public function insert(array $user)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (firstname,lastname,password,mail,num_Tel,role) 
        VALUES (:firstname,:lastname,:password,:mail,:tel,:role)");
        $statement->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('mail', $user['mail'], \PDO::PARAM_STR);
        $statement->bindValue('tel', $user['tel'], \PDO::PARAM_INT);
        $statement->bindValue('role', 'client', \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }


    public function checkEmail($user): bool
    {
        $statement = $this->pdo->query("SELECT `mail` FROM ".self::TABLE." WHERE `mail` ='".$user['mail']."'");

        $result = $statement->rowCount();
        if ($result == 0) {
            return false;
        } else {
            return true;
        }
    }
}

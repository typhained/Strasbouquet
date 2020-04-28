<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class AccountManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function checkmdp($email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE `mail` = :mail");
        $statement->bindValue(':mail', $email, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}

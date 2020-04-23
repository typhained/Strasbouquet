<?php


namespace App\Model;

class CartManager extends AbstractManager
{
    const TABLE = "bouquet";

    /**
     *init this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    // créer un panier pour un user
    public function insert($user)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (id_user) 
        VALUES (:id_user)");
        $statement->bindValue('id_user', $user['id_user'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    // ajouter des produits au panier (bouquet et bouquet concept)
}

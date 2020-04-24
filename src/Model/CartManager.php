<?php


namespace App\Model;

class CartManager extends AbstractManager
{
    const TABLE = "panier";
    const BOUQUETJOIN = "bouquet_panier";
    const BOUQUET = "bouquet";
    const CONCEPT = "concept";

    /**
     *init this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    public function insert($user)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (id_user) 
        VALUES (:id_user)");
        $statement->bindValue('id_user', $user['id_user'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    //voir le panier complet
    public function showCartContent($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::BOUQUETJOIN . " c
        INNER JOIN " .self::BOUQUETJOIN. " bj INNER JOIN ". self::BOUQUET . " b 
        ON bj.id_bouquet=b.id WHERE bj.id_panier= :id ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    public function addBouquetCart($idBouquet)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::BOUQUETJOIN . " 
        (id_panier, id_bouquet) 
        VALUES (:id_panier, :id_bouquet)");
        $statement->bindValue('id_panier', $_SESSION['id_panier'], \PDO::PARAM_INT);
        $statement->bindValue('id_bouquet', $idBouquet, \PDO::PARAM_INT);
        $statement->execute();
    }
}

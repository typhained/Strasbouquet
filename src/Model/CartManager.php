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
        $statement->bindValue('id_user', $user, \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    //voir le panier complet
    public function showCartContent($id)
    {
        $statement = $this->pdo->prepare("SELECT *  FROM " . self::BOUQUETJOIN . " bp INNER JOIN 
        ". self::TABLE ." p ON p.id = bp.id_panier INNER JOIN ". self::BOUQUET." b 
        ON bp.id_bouquet=b.id WHERE bp.id_panier=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function priceCart($id)
    {
        $statement = $this->pdo->prepare("SELECT SUM(b.prix) as total FROM " . self::BOUQUETJOIN . " bp INNER JOIN 
        ". self::TABLE ." p ON p.id = bp.id_panier INNER JOIN ". self::BOUQUET." b 
        ON bp.id_bouquet=b.id WHERE bp.id_panier=:id GROUP BY bp.id_panier");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
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

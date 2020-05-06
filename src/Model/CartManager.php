<?php


namespace App\Model;

class CartManager extends AbstractManager
{
    const TABLE = "panier";
    const BOUQUETJOIN = "bouquet_panier";
    const BOUQUET = "bouquet";
    const CONCEPT = "concept";
    const USER = "user";

    /**
     *init this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert($user, $date)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (id_user, date) 
        VALUES (:id_user, :date)");
        $statement->bindValue('id_user', $user, \PDO::PARAM_INT);
        $statement->bindValue('date', $date, \PDO::PARAM_STR);


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
        $statement = $this->pdo->prepare("SELECT SUM(b.prix*bp.quantite) as 
        total FROM " . self::BOUQUETJOIN . " bp INNER JOIN 
        ". self::TABLE ." p ON p.id = bp.id_panier INNER JOIN ". self::BOUQUET." b 
        ON bp.id_bouquet=b.id WHERE bp.id_panier=:id GROUP BY bp.id_panier");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }



    public function latestCart()
    {
        $statement = $this->pdo->query("SELECT * FROM " . self::TABLE . "   p JOIN " .self::USER. "
        u ON u.id=p.id_user ORDER BY prix_total limit 5");
        return $statement->fetchAll();
    }
}

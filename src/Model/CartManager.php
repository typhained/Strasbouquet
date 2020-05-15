<?php


namespace App\Model;

class CartManager extends AbstractManager
{
    const TABLE = "panier";
    const BOUQUETJOIN = "bouquet_panier";
    const BOUQUET = "bouquet";
    const CONCEPT = "bouquet_concept";
    const CONCEPT_CAT = "bouquet_catalogue";
    const CAT_U = "catalogue_unitaire";
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

    public function showCartContent($id)
    {
        $statement = $this->pdo->prepare("SELECT *  FROM " . self::BOUQUETJOIN . " bp INNER JOIN 
        ". self::TABLE ." p ON p.id = bp.id_panier INNER JOIN ". self::BOUQUET." b 
        ON bp.id_bouquet=b.id WHERE bp.id_panier=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function confirmCart($id)
    {
        $this->pdo->query("UPDATE ".self::TABLE." SET etat='confirme' WHERE id=$id ");
    }

    public function updatePrice($id, $price)
    {
        $statement = $this->pdo->prepare("UPDATE ".self::TABLE." SET prix_total=:price WHERE id=:id ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('price', $price, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function latestCart()
    {
        $statement = $this->pdo->query("SELECT p.id, p.prix_total, u.firstname, u.lastname, p.date
        FROM " . self::TABLE . " p JOIN " .self::USER. "
        u ON u.id=p.id_user WHERE p.etat = 'confirme' ORDER BY date DESC limit 5");
        return $statement->fetchAll();
    }

    public function historiqueID($id)
    {
        $statement = $this->pdo->query("SELECT p.id FROM " . self::TABLE . " p 
        WHERE p.id_user=$id AND p.etat= 'confirme' ORDER BY date DESC, id DESC limit 1");
        return $statement->fetch();
    }

    public function priceTotalConcept($id)
    {
        $statement = $this->pdo->query("SELECT SUM(bc.prix_total) as totalConcept FROM " . self::CONCEPT . " bc
        WHERE bc.id_panier=$id GROUP BY bc.id_panier");
        return $statement->fetch();
    }

    public function conceptInCart($id)
    {
        $statement = $this->pdo->query("SELECT c.id, c.prix_total, 
        GROUP_CONCAT(cu.nom SEPARATOR ' & ') as produit FROM ".self::CONCEPT." c 
        JOIN ".self::CONCEPT_CAT." bc ON bc.id_bouquet_concept=c.id 
        JOIN ".self::CAT_U." cu ON bc.id_catalogue_unitaire=cu.id WHERE c.id_panier=$id GROUP BY c.id ");
        return $statement->fetchAll();
    }

    public function showPriceCart($id)
    {
        return $this->pdo->query("SELECT date, prix_total FROM ".self::TABLE." WHERE id=$id")->fetch();
    }
}

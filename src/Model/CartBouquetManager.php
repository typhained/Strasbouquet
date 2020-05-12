<?php


namespace App\Model;

class CartBouquetManager extends AbstractManager
{
    const TABLE = "bouquet_panier";
    const CART = "panier";
    const BOUQUET = "bouquet";

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function addBouquetCart($idBouquet, $panier)
    {
        $qte = 1;
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (id_panier, id_bouquet, quantite ) 
        VALUES (:id_panier, :id_bouquet, :quantite)");
        $statement->bindValue('id_panier', $panier, \PDO::PARAM_INT);
        $statement->bindValue('id_bouquet', $idBouquet, \PDO::PARAM_INT);
        $statement->bindValue('quantite', $qte, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function bouquetInCart($idBouquet, $panier)
    {
        $statement = $this->pdo->query("SELECT `id_bouquet` FROM ".self::TABLE."
         WHERE `id_bouquet` =" .$idBouquet. " AND id_panier = ".$panier." ");
        $result = $statement->rowCount();
        if ($result == 0) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function priceCartBouquet(int $id)
    {
        $statement = $this->pdo->prepare("SELECT SUM(b.prix*bp.quantite) as 
        totalBouquet FROM " . self::TABLE . " bp INNER JOIN 
        ". self::CART ." p ON p.id = bp.id_panier INNER JOIN ". self::BOUQUET." b 
        ON bp.id_bouquet=b.id WHERE bp.id_panier=:id GROUP BY bp.id_panier");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    /**
     * @param int $idBouquet
     * @return mixed
     */
    public function selectQuantiteBouquet(int $idBouquet, int $idpanier)
    {
        $statement = $this->pdo->query("SELECT quantite FROM ".self::TABLE."
         WHERE `id_bouquet`=$idBouquet AND id_panier=$idpanier");
        return $statement->fetch();
    }

    public function updateBouquetCart($idBouquet, $qte, $idpanier)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET
        quantite = $qte WHERE id_bouquet=$idBouquet AND id_panier=$idpanier ");
        $statement->execute();
    }

    public function delete($idBouquet, $idpanier)
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . "
WHERE id_bouquet=$idBouquet AND id_panier=$idpanier");
        $statement->execute();
    }
}

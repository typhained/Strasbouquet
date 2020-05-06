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

    public function addBouquetCart($idBouquet)
    {
        $qte = 1;
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (id_panier, id_bouquet, quantite ) 
        VALUES (:id_panier, :id_bouquet, :quantite)");
        $statement->bindValue('id_panier', $_SESSION['id_panier'], \PDO::PARAM_INT);
        $statement->bindValue('id_bouquet', $idBouquet, \PDO::PARAM_INT);
        $statement->bindValue('quantite', $qte, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function bouquetInCart($idBouquet)
    {
        $statement = $this->pdo->query("SELECT `id_bouquet` FROM ".self::TABLE." WHERE `id_bouquet` =$idBouquet");
        $result = $statement->rowCount();
        if ($result == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function selectQuantiteBouquet($idBouquet)
    {
        $statement = $this->pdo->query("SELECT quantite FROM ".self::TABLE."
         WHERE `id_bouquet` ='".$idBouquet."'");
        return $statement->fetch();
    }

    public function updateBouquetCart($idBouquet, $qte)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET
        quantite = $qte WHERE id_bouquet=$idBouquet");
        $statement->execute();
    }
}

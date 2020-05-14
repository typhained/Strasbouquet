<?php

namespace App\Model;

class GalerieManager extends AbstractManager
{
    const TABLE = "galerie";
    const BOUQUET = "bouquet";
    const CATALOGUE = "catalogue_unitaire";

    /**
    *init this class.
    */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectImageBouquet(int $id)
    {
        // prepared request
        $statement = $this->pdo->query("SELECT * FROM ". self::TABLE .
        " WHERE id_bouquet = $id");
        $statement->execute();

        return $statement->fetch();
    }
    /**id_bouquet
     *
     * @param int $id
     */
    public function deleteBouquet(int $id): void
    {
        // prepared request
        $statement = $this->pdo->query("DELETE FROM ". self::TABLE . " WHERE id_bouquet = $id");
        $statement->execute();
    }
    /**
     * insert into
     */
    public function insertBouquet($galerie, $bouquet)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (nom, file1, id_bouquet) VALUES (:nom, :file1, :id_bouquet) ");
        $statement->bindValue('nom', $bouquet['nom'], \PDO::PARAM_STR);
        $statement->bindValue('file1', $galerie, \PDO::PARAM_STR);
        $statement->bindValue('id_bouquet', $bouquet['id'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function insertCatalogueU($galerie, $catalogueU, $id)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (nom, file1, id_catalogue_unitaire) VALUES (:nom, :file1, :id_catalogue_unitaire) ");
        $statement->bindValue('nom', $catalogueU['nom'], \PDO::PARAM_STR);
        $statement->bindValue('file1', $galerie, \PDO::PARAM_STR);
        $statement->bindValue('id_catalogue_unitaire', $id, \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function deleteCatalogueU($id)
    {
        $statement = $this->pdo->query("DELETE FROM ". self::TABLE . " WHERE id_catalogue_unitaire = $id");
        $statement->execute();
    }
}

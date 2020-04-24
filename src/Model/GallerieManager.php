<?php

namespace App\Model;

class GallerieManager extends AbstractManager
{
    const TABLE = "gallerie";
    const BOUQUET = "bouquet";
    const CATALOGUE = "catalogue_unitaire";

    /**
    *init this class.
    */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $gallerie): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (nom, prix, description, saisonnier)
        VALUES (:nom, :prix, :description, :saisonnier)");
        $statement->bindValue('nom', $gallerie['nom'], \PDO::PARAM_STR);
        $statement->bindValue('file1', $gallerie['file1'], \PDO::PARAM_INT);
        $statement->bindValue('file2', $gallerie['file2'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}

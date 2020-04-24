<?php

namespace App\Model;

class CatalogueUManager extends AbstractManager
{
    const TABLE = 'catalogue_unitaire';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $catalogueU): int
    {
        // prepared request
        $prix = $catalogueU['prix'];
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (nom, type, prix, couleur) VALUES (:nom, :type, ".$prix.", :couleur)");
        $statement->bindValue('nom', $catalogueU['nom'], \PDO::PARAM_STR);
        $statement->bindValue('type', $catalogueU['type'], \PDO::PARAM_STR);
        $statement->bindValue('couleur', $catalogueU['couleur'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function update(array $catalogueU):bool
    {

        // prepared request
        $prix = $catalogueU['prix'];
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE ."
             SET nom=:nom, type=:type, prix=".$prix.", couleur=:couleur WHERE id=:id");
        $statement->bindValue('id', $catalogueU['id'], \PDO::PARAM_INT);
        $statement->bindValue('nom', $catalogueU['nom'], \PDO::PARAM_STR);
        $statement->bindValue('type', $catalogueU['type'], \PDO::PARAM_STR);
        $statement->bindValue('couleur', $catalogueU['couleur'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}

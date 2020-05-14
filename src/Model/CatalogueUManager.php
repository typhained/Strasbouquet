<?php

namespace App\Model;

class CatalogueUManager extends AbstractManager
{
    const TABLE = 'catalogue_unitaire';
    const GALERIE = 'galerie';
    const BOUQUET = "bouquet";

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

    public function selectOneById(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " JOIN " . self::GALERIE .
        " ON catalogue_unitaire.id = galerie.id_catalogue_unitaire WHERE catalogue_unitaire.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
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

    public function filterType()
    {
        $statement = $this->pdo->query("SELECT type FROM ".self::TABLE." GROUP by type");
        return $statement->fetchAll();
    }

    public function filterColor()
    {
        $statement = $this->pdo->query("SELECT couleur FROM ".self::TABLE." GROUP by couleur");
        return $statement->fetchAll();
    }

    public function filterNom()
    {
        $statement = $this->pdo->query("SELECT nom FROM ".self::TABLE." GROUP by nom");
        return $statement->fetchAll();
    }
}

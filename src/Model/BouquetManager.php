<?php

namespace App\Model;

class BouquetManager extends AbstractManager
{
    const TABLE = "bouquet";

    /**
     *init this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * test
     */
    public function insert(array $bouquet): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (nom, prix, description, saisonnier)
        VALUES (:nom, :prix, :description, :saisonnier)");
        $statement->bindValue('nom', $bouquet['nom'], \PDO::PARAM_STR);
        $statement->bindValue('prix', $bouquet['prix'], \PDO::PARAM_STR);
        $statement->bindValue('description', $bouquet['description'], \PDO::PARAM_STR);
        $statement->bindValue('saisonnier', $bouquet['saisonnier'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
    /**
     * @param array $bouquet
     * @return bool
     */
    public function update(array $bouquet): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
            " SET nom = :nom, prix = :prix, description = :description, saisonnier = :saisonnier WHERE id=:id");
        $statement->bindValue('id', $bouquet['id'], \PDO::PARAM_INT);
        $statement->bindValue('nom', $bouquet['nom'], \PDO::PARAM_STR);
        $statement->bindValue('prix', $bouquet['prix'], \PDO::PARAM_STR);
        $statement->bindValue('description', $bouquet['description'], \PDO::PARAM_STR);
        $statement->bindValue('saisonnier', $bouquet['saisonnier'], \PDO::PARAM_STR);

        return $statement->execute();
    }
    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
    public function filter(string $filter): array
    {
        $statement = $this->pdo->query(" SELECT * FROM " . self::TABLE . " WHERE saisonnier = '" . $filter . "' ");
        return $statement->fetchAll();
    }
}

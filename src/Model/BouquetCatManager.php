<?php

namespace App\Model;

class BouquetCatManager extends AbstractManager
{
    const TABLE = 'bouquet_catalogue';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @return false|\PDOStatement
     */
    public function select()
    {
        return $this->pdo->query("SELECT bc.id_bouquet_concept, cu.nom, cu.type, cu.couleur, cu.prix 
        FROM " . self::TABLE . " bc JOIN catalogue_unitaire cu ON cu.id=bc.id_catalogue_unitaire");
    }

    /**
     * @param int $unit
     * @return array
     */
    public function unitInConcept(int $unit, int $idConcept)
    {
        $statement = $this->pdo->query("SELECT quantite FROM " . self::TABLE . " 
        WHERE id_catalogue_unitaire = " . $unit . " AND id_bouquet_concept = " . $idConcept);

        return $statement->fetch(\PDO::FETCH_NUM);
    }

    /**
     * INSERT joint table
     *
     * @param int $idConcept
     * @param int $unit
     */
    public function insert(int $idConcept, int $unit)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " VALUES (:id_bouquet_concept, :id_catalogue_unitaire, 1)");
        $statement->bindValue('id_bouquet_concept', $idConcept, \PDO::PARAM_INT);
        $statement->bindValue('id_catalogue_unitaire', $unit, \PDO::PARAM_INT);

        $statement->execute();
    }

    public function updateQuantUp(int $idConcept, int $unit)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " bc SET bc.quantite = bc.quantite + 1 
        WHERE bc.id_bouquet_concept = :id_bouquet_concept AND bc.id_catalogue_unitaire = :id_catalogue_unitaire");
        $statement->bindValue('id_bouquet_concept', $idConcept, \PDO::PARAM_INT);
        $statement->bindValue('id_catalogue_unitaire', $unit, \PDO::PARAM_INT);

        $statement->execute();
    }

    public function updateQuantDwn(int $idConcept, int $unit)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " bc SET bc.quantite = bc.quantite - 1 
        WHERE bc.id_bouquet_concept = :id_bouquet_concept AND bc.id_catalogue_unitaire = :id_catalogue_unitaire");
        $statement->bindValue('id_bouquet_concept', $idConcept, \PDO::PARAM_INT);
        $statement->bindValue('id_catalogue_unitaire', $unit, \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * @param int $idUnit
     * @return int
     */
    public function getUnitQuant(int $idUnit) : int
    {
        $statement = $this->pdo->query("SELECT quantite FROM " . self::TABLE . " 
        WHERE id_catalogue_unitaire = " . $idUnit);

        $array = $statement->fetch(\PDO::FETCH_NUM);
        return $array[0];
    }

    public function delete(int $idConcept, int $unit)
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " bc 
            WHERE bc.id_bouquet_concept = :id_concept AND bc.id_catalogue_unitaire = :unit");
        $statement->bindValue('id_concept', $idConcept, \PDO::PARAM_INT);
        $statement->bindValue('unit', $unit, \PDO::PARAM_INT);
        $statement->execute();
    }
}

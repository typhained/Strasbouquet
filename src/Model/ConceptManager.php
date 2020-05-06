<?php


namespace App\Model;

class ConceptManager extends AbstractManager
{
    const TABLE = 'bouquet_concept';
    const JOIN = 'bouquet_catalogue';
    const CATALOGUE_U = 'catalogue_unitaire';

    /**
     * ConceptManager constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param int $id
     * @return array
     */
    public function showConcept(int $id)
    {
        $statement = $this->pdo->query("SELECT * FROM " . self::JOIN . " bc 
        JOIN " . self::CATALOGUE_U ." cu ON bc.id_catalogue_unitaire=cu.id 
        JOIN " . self::TABLE . " c ON bc.id_bouquet_concept=c.id 
        WHERE c.id = " . $id);

        return $statement->fetchAll();
    }

    /**
     * @param array $concept
     * @return int
     */
    public function insert(array $concept)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        VALUES (NULL, :id_user, NULL, NULL, NULL, :date)");
        $statement->bindValue(':id_user', $concept['id_user'], \PDO::PARAM_INT);
        $statement->bindValue(':date', $concept['date'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function insertCart(int $id, int $cart)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " 
        SET id_panier = :id_panier WHERE id = :id");
        $statement->bindValue(':id_panier', $cart, \PDO::PARAM_INT);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }

    public function delete(int $id)
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id= :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}

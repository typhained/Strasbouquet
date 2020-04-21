<?php


namespace App\Model;

class ConceptManager extends AbstractManager
{
    const TABLE = 'bouquet_concept';

    /**
     * ConceptManager constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $concept)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        VALUES (NULL, :id_user, :id_panier, NULL, NULL)");
        $statement->bindValue('id_user', $concept['id_user'], \PDO::PARAM_INT);
        $statement->bindValue('id_panier', $concept['id_panier'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function delete(int $id)
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id= :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}

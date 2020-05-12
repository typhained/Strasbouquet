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
     * @param int $user
     * @return array
     */
    public function selectByUserDate(int $user)
    {
        $query = $this->pdo->query("SELECT * FROM " . self::TABLE . " WHERE id_user=$user AND `date` = DATE(NOW())");
        return $query->fetchAll();
    }

    /**
     * Select all the bouquets concepts
     *
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
     * Insert a new bouquet concept
     *
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

    /**
     * @return array
     */
    public function fetchPrice(int $concept) : array
    {
        $statement = $this->pdo->prepare("SELECT SUM(cu.prix * bc.quantite) AS total 
            FROM " . self::CATALOGUE_U . " cu 
            JOIN " . self::JOIN . " bc ON bc.id_catalogue_unitaire=cu.id 
            JOIN " . self::TABLE . " c ON c.id=bc.id_bouquet_concept 
            WHERE c.id=:id");
        $statement->bindValue(':id', $concept, \PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $idUnit
     * @return int
     */
    public function getUnitPrice(int $idUnit) : int
    {
        $statement = $this->pdo->query("SELECT cu.prix FROM " . self::CATALOGUE_U . " cu 
            WHERE cu.id=" . $idUnit);

        $array = $statement->fetch(\PDO::FETCH_NUM);
        return $array[0];
    }

    /**
     * Update the price of the custom bouquet
     *
     * @param int $price
     * @param int $idConcept
     */
    public function updatePrice(int $price, int $idConcept)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET prix_total = :price WHERE id = :idConcept");
        $statement->bindValue(':price', $price, \PDO::PARAM_INT);
        $statement->bindValue(':idConcept', $idConcept, \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getCard(int $id)
    {
        $query = $this->pdo->query("SELECT carte FROM " . self::TABLE . " WHERE id= $id");
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        return $result['carte'];
    }

    /**
     * Add a card to the custom bouquet
     * @param int $card
     * @param int $idConcept
     */
    public function updateCard(int $card, int $idConcept)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET carte = :carte WHERE id = :idConcept");
        $statement->bindValue(':carte', $card, \PDO::PARAM_INT);
        $statement->bindValue(':idConcept', $idConcept, \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Assign a bouquet concept to a cart
     *
     * @param int $id
     * @param int $cart
     */
    public function updateCart(int $id, int $cart)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " 
        SET id_panier = :id_panier WHERE id = :id");
        $statement->bindValue(':id_panier', $cart, \PDO::PARAM_INT);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Delete a bouquet concept
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id= :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}

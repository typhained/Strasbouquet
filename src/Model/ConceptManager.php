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

    public function insert()
    {
        $statement = $this->pdo->prepare("INSERT INTO ");
    }
}

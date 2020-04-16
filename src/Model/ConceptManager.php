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
}

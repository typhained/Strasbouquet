<?php


namespace App\Model;

class CatUnitManager extends AbstractManager
{
    const TABLE = 'catalogue_unitaire';

    /**
     * CatUnitManager constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}

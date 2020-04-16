<?php


namespace App\Model;

class CatUnitManager extends AbstractManager
{
    const TABLE = 'catalogue_unitaire';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}

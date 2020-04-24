<?php

namespace App\Model;

class GallerieManager extends AbstractManager
{
    const TABLE = "gallerie";
    const BOUQUET = "bouquet";
    const CATALOGUE = "catalogue_unitaire";

    /**
    *init this class.
    */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneImage(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM gallerie 
        INNER JOIN bouquet WHERE :bouquet.id = gallerie.id_bouquet");
        $statement->bindValue('bouquet.id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}

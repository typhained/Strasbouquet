<?php


namespace App\Model;

class BouquetCatManager extends AbstractManager
{
    const TABLE = 'bouquet_catalogue';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function select()
    {
        return $this->pdo->query("SELECT bc.id_bouquet_concept, cu.nom, cu.type, cu.couleur, cu.prix 
        FROM " . self::TABLE . " bc JOIN catalogue_unitaire cu ON cu.id=bc.id_catalogue_unitaire");
    }
}

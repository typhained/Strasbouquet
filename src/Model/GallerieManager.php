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
    public function selectImageBouquet(int $id)
    {
        // prepared request
        $statement = $this->pdo->query("SELECT * FROM ". self::TABLE .
        " WHERE id_bouquet = $id");
        $statement->execute();

        return $statement->fetch();
    }
    /**id_bouquet            | int          | YES  | MUL | NULL    |                |
    | id_catalogue_
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . "
         INNER JOIN ".self::BOUQUET. "WHERE :bouquet.id = gallerie.id_bouquet");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
    /**
     * insert into
     */
    public function insertBouquet($gallerie, $bouquet)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (nom, file1, id_bouquet) VALUES (:nom, :file1, :id_bouquet) ");
        $statement->bindValue('nom', $bouquet['nom'], \PDO::PARAM_STR);
        $statement->bindValue('file1', $gallerie, \PDO::PARAM_STR);
        $statement->bindValue('id_bouquet', $bouquet['id'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}

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
        $statement = $this->pdo->prepare("SELECT * FROM ". self::TABLE ."
        INNER JOIN ".self::BOUQUET." WHERE :bouquet.id = gallerie.id_bouquet");
        $statement->bindValue('bouquet.id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
    /**
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
    public function insertBouquet(array $gallerie): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(nom, file1, file2, id_bouquet)
        VALUES (:nom, :file1, :file2, :id_bouquet)");
        $statement->bindValue('nom', $gallerie['nom'], \PDO::PARAM_STR);
        $statement->bindValue('file1', $gallerie['file1'], \PDO::PARAM_STR);
        $statement->bindValue('file2', $gallerie['file2'], \PDO::PARAM_STR);
        $statement->bindValue('id_bouquet', $gallerie['id_bouquet'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}

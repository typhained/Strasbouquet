<?php


namespace App\Controller;

use App\Model\BouquetCatManager;
use App\Model\CatalogueUManager;
use App\Model\ConceptManager;

class BouquetCatController extends AbstractController
{
    public function showConcept()
    {
        $bouquetCatManager = new BouquetCatManager();
        $bouquet = $bouquetCatManager->select();

        return $this->twig->render('/Concept/show.html.twig', ['bouquet' => $bouquet]);
    }

    /**
     * Add or update quantity
     *
     * @param int $unit
     */
    public function add(int $unit)
    {
        $idConcept = $_SESSION['id_bouquet_concept'];
        $bouquetCatManager = new BouquetCatManager();

        if (empty($bouquetCatManager->unitInConcept($unit))) {
            $bouquetCatManager->insert($idConcept, $unit);
        } else {
            $bouquetCatManager->updateQuantUp($idConcept, $unit);
        }

        header('location: /Concept/show/' . $_SESSION['id_bouquet_concept']);
    }

    /**
     * Delete or update quantity
     *
     * @param int $unit
     */
    public function delete(int $unit)
    {
        $idConcept = $_SESSION['id_bouquet_concept'];
        $bouquetCatManager = new BouquetCatManager();
        if ($bouquetCatManager->unitInConcept($unit)[0] > 1) {
            $bouquetCatManager->updateQuantDwn($idConcept, $unit);
        } else {
            $bouquetCatManager->delete($idConcept, $unit);
        }

        header('location: /Concept/show/' . $_SESSION['id_bouquet_concept']);
    }
}

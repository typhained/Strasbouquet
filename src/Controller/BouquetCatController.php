<?php


namespace App\Controller;

use App\Model\BouquetCatManager;
use App\Model\ConceptManager;
use App\Model\CatalogueUManager;

class BouquetCatController extends AbstractController
{
    public function showConcept()
    {
        $bouquetCatManager = new BouquetCatManager();
        $bouquet = $bouquetCatManager->select();

        return $this->twig->render('/Concept/show.html.twig', ['bouquet' => $bouquet]);
    }

    /**
     * Add an unit, or update quantity
     *
     * @param int $unit
     * @return void
     */
    public function add(int $unit) : void
    {
        $idConcept = $_SESSION['id_bouquet_concept'];
        $bouquetCatManager = new BouquetCatManager();
        $conceptManager = new ConceptManager();

        if (empty($bouquetCatManager->unitInConcept($unit, $idConcept))) {
            $bouquetCatManager->insert($idConcept, $unit);
        } else {
            $bouquetCatManager->updateQuantUp($idConcept, $unit);
        }

        $unitPrice = $conceptManager->getUnitPrice($unit);
        $unitQuant = $bouquetCatManager->getUnitQuant($unit);
        $price = ($unitPrice * $unitQuant);
        $_SESSION['price'] = $price;

        $conceptManager->updatePrice($price, $unit);

        header('location: /Concept/show/' . $idConcept);
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
        if ($bouquetCatManager->unitInConcept($unit, $idConcept)[0] > 1) {
            $bouquetCatManager->updateQuantDwn($idConcept, $unit);
        } else {
            $bouquetCatManager->delete($idConcept, $unit);
        }

        header('location: /Concept/show/' . $_SESSION['id_bouquet_concept']);
    }
}

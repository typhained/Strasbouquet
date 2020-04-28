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

    public function add(int $unit)
    {
        $idConcept = $_SESSION['id_bouquet_concept'];
        $bouquetCatManager = new BouquetCatManager();
        $bouquetCatManager->insert($idConcept, $unit);

        header('location: /Concept/show/' . $_SESSION['id_bouquet_concept']);
    }
}

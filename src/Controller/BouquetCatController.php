<?php


namespace App\Controller;

use App\Model\BouquetCatManager;
use App\Model\CatUnitManager;
use App\Model\ConceptManager;

class BouquetCatController extends AbstractController
{
    public function showConcept()
    {
        $bouquetCatManager = new BouquetCatManager();
        $bouquet = $bouquetCatManager->select();

        return $this->twig->render('/Concept/show.html.twig', ['bouquet' => $bouquet]);
    }
}

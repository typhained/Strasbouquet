<?php

namespace App\Controller;

use App\Model\BouquetManager;
use App\Model\ConceptManager;
use App\Model\UserManager;

class FrontController extends AbstractController
{
    public function index()
    {
        $conceptManager = new ConceptManager();
        $concepts = $conceptManager->selectAll();
        return $this->twig->render('Front/index.html.twig', ['concepts' => $concepts]);
    }

    public function show(int $id)
    {
        $conceptManager = new ConceptManager();
        $concept = $conceptManager->selectOneById($id);
        return $this->twig->render('Front/show.html.twig', ['concept' => $concept]);
    }
    public function filter(string $filter)
    {
        $bouquetManager = new BouquetManager();
        $bouquets = $bouquetManager->filter($filter);

        return $this->twig->render('Front/bouquets.html.twig', ['bouquets' => $bouquets]);
    }
}

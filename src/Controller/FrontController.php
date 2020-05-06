<?php

namespace App\Controller;

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
}

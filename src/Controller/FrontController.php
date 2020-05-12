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

    public function bouquets()
    {
        $bouquetManager= new BouquetManager();
        $bouquets = $bouquetManager->selectAll();
        if (!isset($_SESSION['id_panier'])) {
            $panier="";
        } else {
            $panier = $_SESSION['id_panier'];
        }
        return $this->twig->render(
            'Front/bouquets.html.twig',
            ["bouquets" => $bouquets, "panier" => $panier]
        );
    }

    public function filter(string $filter)
    {
        $bouquetManager = new BouquetManager();
        $bouquets = $bouquetManager->filter($filter);

        return $this->twig->render('Front/bouquets.html.twig', ['bouquets' => $bouquets]);
    }
}

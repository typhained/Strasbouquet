<?php

namespace App\Controller;

use App\Model\BouquetManager;
use App\Model\ConceptManager;
use App\Model\GalerieManager;
use App\Model\UserManager;

class FrontController extends AbstractController
{
    public function index()
    {
        $userManager = new UserManager();

        if (isset($_SESSION['user'])) {
            $user = $userManager->selectOneById($_SESSION['user']);
        } else {
            $user = null;
        }

        // Randomisation de 4 bouquets
        $bouquetManager = new BouquetManager();
        $galerieManager = new GalerieManager();

        $bouquets = $bouquetManager->selectAll();
        shuffle($bouquets);
        $bouquetsRand = [
            $bouquets[0],
            $bouquets[1],
            $bouquets[2],
            $bouquets[3]
        ];
        $images = $galerieManager->selectAll();

        return $this->twig->render('Front/index.html.twig', [
            'user' => $user,
            'bouquets' => $bouquetsRand,
            'images' => $images,
            ]);
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function bouquets()
    {
        $galerieManager = new GalerieManager();
        $bouquetManager= new BouquetManager();
        $bouquets = $bouquetManager->selectAll();
        $images = $galerieManager->selectAll();
        $saisonniers = $bouquetManager->saisonnier();

        if (!isset($_SESSION['id_panier'])) {
            $panier="";
        } else {
            $panier = $_SESSION['id_panier'];
        }
        return $this->twig->render(
            'Front/bouquets.html.twig',
            ["bouquets" => $bouquets,
                "panier" => $panier,
                "images"=>$images,
                "saisonniers"=>$saisonniers]
        );
    }

    public function filter(string $filter)
    {
        $bouquetManager = new BouquetManager();
        $bouquets = $bouquetManager->filter($filter);
        $saisonniers = $bouquetManager->saisonnier();
        return $this->twig->render(
            'Front/bouquets.html.twig',
            ['bouquets' => $bouquets, "saisonniers" => $saisonniers]
        );
    }
}

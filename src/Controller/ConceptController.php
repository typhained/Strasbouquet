<?php

namespace App\Controller;

use App\Model\ConceptManager;
use App\Model\CatalogueUManager;
use App\Model\BouquetCatManager;
use DateTime;

/**
 * Class ConceptController
 * @package App\Controller
 */
class ConceptController extends AbstractController
{
    /**
     * Display Concept page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $conceptManager = new ConceptManager();
        $concepts = $conceptManager->selectAll();

        return $this->twig->render('Concept/index.html.twig', ['concepts' => $concepts]);
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create()
    {
        $conceptManager = new ConceptManager();
        $date = new DateTime("now");
        $concept = [
            'id_user' => $_POST['id_user'],
            'id_panier' => $_POST['id_panier'],
            'date' => $date->format('Y-m-d')
        ];
        $id = $conceptManager->insert($concept);

        if (!empty($_SESSION['id_bouquet_concept'])) {
            $_SESSION['id_bouquet_concept'] = $id;
        }

        header('location: /Concept/show/' . $id);
    }

    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $conceptManager = new ConceptManager();

        if (!isset($_SESSION['id_bouquet_concept'])) {
            $_SESSION['id_bouquet_concept'] = $id;
        }

        if ($id != $_SESSION['id_bouquet_concept']) {
            $_SESSION['id_bouquet_concept'] = $id;
        }

        $concept = $conceptManager->showConcept($id);

        $catalogueUManager = new CatalogueUManager();
        $units = $catalogueUManager->selectAll();

        return $this->twig->render('Concept/show.html.twig', ['concept' => $concept, 'units' => $units]);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $conceptManager = new ConceptManager();
        $conceptManager->delete($id);
        header('location: /Concept/index');
    }
}

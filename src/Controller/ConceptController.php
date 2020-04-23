<?php


namespace App\Controller;

use App\Model\ConceptManager;
use App\Model\CatUnitManager;
use App\Model\BouquetCatManager;

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
        $concept = [
            'id_user' => $_POST['id_user'],
            'id_panier' => $_POST['id_panier'],
        ];
        $id = $conceptManager->insert($concept);

        header('location: /Concept/show/' . $id);
    }

    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show($id)
    {
        $conceptManager = new ConceptManager();
        $concept = $conceptManager->selectOneById($id);

        $catUnitManager = new CatUnitManager();
        $units = $catUnitManager->selectAll();

        return $this->twig->render('Concept/show.html.twig', ['concept' => $concept, 'units' => $units]);
    }

    public function add(int $concept, int $unit)
    {
        $conceptManager = new ConceptManager();
        $bouquetCatManager = new BouquetCatManager();
        $catUnitManager = new CatUnitManager();


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

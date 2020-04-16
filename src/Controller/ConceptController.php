<?php


namespace App\Controller;

use App\Model\ConceptManager;
use App\Model\CatUnitManager;

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
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $conceptManager = new ConceptManager();
        $concept = $conceptManager->selectOneById($id);

        return $this->twig->render('Concept/show.html.twig', ['concept' => $concept]);
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create()
    {
        $catUnitManager = new CatUnitManager();
        $units = $catUnitManager->selectAll();

        return $this->twig->render('Concept/create.html.twig', ['units' => $units]);
    }
}

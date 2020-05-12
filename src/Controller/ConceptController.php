<?php

namespace App\Controller;

use App\Model\ConceptManager;
use App\Model\CatalogueUManager;
use App\Model\BouquetCatManager;
use App\Model\CartManager;
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
     * Create a new Bouquet Concept
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create()
    {
        $conceptManager = new ConceptManager();

        $user = $_SESSION['user'];
        $date = new DateTime("now");
        $date = $date->format('Y-m-d');


        $concept = [
            'id_user' => $user,
            'date' => $date
        ];
        $id = $conceptManager->insert($concept);

        if (!empty($_SESSION['id_bouquet_concept'])) {
            $_SESSION['id_bouquet_concept'] = $id;
        }

        header('location: /Concept/show/' . $id);
    }

    /**
     * Display a bouquet concept
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id):string
    {
        $conceptManager = new ConceptManager();

        if (!isset($_SESSION['id_bouquet_concept'])) {
            $_SESSION['id_bouquet_concept'] = $id;
        }

        if ($id != $_SESSION['id_bouquet_concept']) {
            $_SESSION['id_bouquet_concept'] = $id;
        }

        $idConcept = $_SESSION['id_bouquet_concept'];

        $concept = $conceptManager->showConcept($id);

        $catalogueUManager = new CatalogueUManager();
        $units = $catalogueUManager->selectAll();

        $price = $conceptManager->fetchPrice($id);


        return $this->twig->render(
            'Concept/show.html.twig',
            [
                'concept' => $concept,
                'units' => $units,
                'idConcept' => $idConcept,
                'price' => $price
            ]
        );
    }

    /**
     * Delete a bouquet concept
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $conceptManager = new ConceptManager();
        $conceptManager->delete($id);
        header('location: /Concept/index');
    }

    /**
     * Add a bouquet concept to the cart
     *
     * @param int $idConcept
     * @return mixed
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addToCart(int $idConcept)
    {
        // Check if client is logged
        if (!isset($_SESSION['user'])) {
            $message = "Vous devez vous inscrire ou vous connecter pour commmander";
            // If not logged, sign in
            return $this->twig->render('User/add.html.twig', ["message" => $message]);
        // Log check passed
        } else {
            // Check if cart ID is not defined
            if (!isset($_SESSION['id_panier'])) {
                // New CartManager object
                $cartManager = new CartManager();

                // Define a user variable
                $user = $_SESSION['user'];
                // New current date object
                $date = new DateTime("now");
                // Passing date to the right format
                $date = $date->format('Y-m-d');

                // Create a cart and returning the ID
                $id = $cartManager->insert($user, $date);
                // Passing cart ID to SESSION global
                $_SESSION['id_panier'] = $id;
            }

            // New ConceptManager object
            $conceptManager = new ConceptManager();

            // Define a cart ID
            $cart = $_SESSION['id_panier'];
            // Assign the custom bouquet to the cart
            $conceptManager->updateCart($idConcept, $cart);

            // Redirect towards the cart
            header("location: /Cart/showCart/$cart");
        }
    }
}

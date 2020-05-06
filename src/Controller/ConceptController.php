<?php

namespace App\Controller;

use App\Model\ConceptManager;
use App\Model\CatalogueUManager;
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
    public function show(int $id)
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

        return $this->twig->render('Concept/show.html.twig', [
            'concept' => $concept, 'units' => $units, 'idConcept' => $idConcept
        ]);
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
        if (!isset($_SESSION['user'])) {    // Check if client is logged
            $message = "Vous devez vous inscrire ou vous connecter pour commmander";
            return $this->twig->render('User/add.html.twig', ["message" => $message]);  // If not logged, sign in
        } else {    // Log check passed
            if (!isset($_SESSION['id_panier'])) {   // Check if cart ID is not defined
                $cartManager = new CartManager();   // New CartManager object

                $user = $_SESSION['user'];  // Define a user variable
                $date = new DateTime("now");    // New current date object
                $date = $date->format('Y-m-d'); // Passing date to the right format

                $id = $cartManager->insert($user, $date);   // Create a cart and returning the ID
                $_SESSION['id_panier'] = $id;   // Passing cart ID to SESSION global
            }

            $conceptManager = new ConceptManager(); // New ConceptManager object

            $cart = $_SESSION['id_panier']; // Define a cart ID
            $conceptManager->updateCart($idConcept, $cart); // Assign the custom bouquet to the cart

            header("location: /Cart/showCart/$cart");   // Redirect towards the cart
        }
    }
}

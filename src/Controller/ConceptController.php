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
        if (!empty($_SESSION['user'])) {
            $user = $_SESSION['user'];

            $conceptManager = new ConceptManager();
            $concepts = $conceptManager->selectByUserDate($user);

            return $this->twig->render('Concept/index.html.twig', [
                'concepts' => $concepts,
            ]);
        } else {
            header('location: ../Account/login');
        }
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
        if (!empty($_SESSION['user'])) {
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
        } else {
            header('location: /Account/login');
        }
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['card'] == 'add-card') {
                $conceptManager->updateCard(1, $id);
            } else {
                $conceptManager->updateCard(0, $id);
            }
        }

        $idConcept = $_SESSION['id_bouquet_concept'];

        $concept = $conceptManager->showConcept($id);

        $catalogueUManager = new CatalogueUManager();
        $units = $catalogueUManager->selectAll();

        $price = $conceptManager->fetchPrice($id);

        if ($price['total'] == null) {
            $price['total'] = 0;
        }

        $conceptManager->updatePrice($price['total'], $id);

        $card = $conceptManager->getCard($id);

        return $this->twig->render(
            'Concept/show.html.twig',
            [
                'concept' => $concept,
                'units' => $units,
                'idConcept' => $idConcept,
                'price' => $price,
                'carte' => $card
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
        if (!isset($_SESSION['user'])) {
            $message = "Vous devez vous inscrire ou vous connecter pour commmander";
            return $this->twig->render('User/add.html.twig', ["message" => $message]);
        } else {
            if (!isset($_SESSION['id_panier'])) {
                $cartManager = new CartManager();

                $user = $_SESSION['user'];
                $date = new DateTime("now");
                $date = $date->format('Y-m-d');

                $id = $cartManager->insert($user, $date);
                $_SESSION['id_panier'] = $id;
            }

            $conceptManager = new ConceptManager();

            $cart = $_SESSION['id_panier'];
            $conceptManager->updateCart($idConcept, $cart);

            header("location: /Cart/showCart/$cart");
        }
    }
}

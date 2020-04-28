<?php


namespace App\Controller;

use App\Model\BouquetManager;
use App\Model\CartManager;

class CartController extends AbstractController
{
    public function showBouquet()
    {
        $bouquetManager= new BouquetManager();
        $bouquets = $bouquetManager->selectAll();
        if (!isset($_SESSION['id_panier'])) {
            $panier="";
        } else {
            $panier = $_SESSION['id_panier'];
        }
        return $this->twig->render(
            'Front/index.html.twig',
            ["bouquets" => $bouquets, "panier" => $panier]
        );
    }


    public function addBouquetCart($idBouquet)
    {
        if (!isset($_SESSION['user'])) {
            $message = "Vous devez vous inscrire ou vous connecter pour commmander";
            return $this->twig->render('User/add.html.twig', ["message" => $message]);
        } else {
            $cartManager = new CartManager();
            $user = ($_SESSION['user']);

            if (!isset($_SESSION['id_panier'])) {
                $id = $cartManager->insert($user);
                $_SESSION['id_panier'] =  $id;
                $cartManager->addBouquetCart($idBouquet);
            } else {
                $cartManager->addBouquetCart($idBouquet);
            }
            $bouquetManager= new BouquetManager();
            $bouquets = $bouquetManager->selectAll();
            $panier = $_SESSION['id_panier'];
            return $this->twig->render('Front/index.html.twig', ["bouquets" => $bouquets, "panier" => $panier]);
        }
    }

    public function showCart($id)
    {
        if (!isset($_SESSION['user'])) {
            $message = "Vous devez vous inscrire ou vous connecter pour commmander";
            return $this->twig->render('User/add.html.twig', ["message" => $message]);
        } else {
            $cartManager = new CartManager();
            $panier = $cartManager->showCartContent($id);
            $price = $cartManager->priceCart($id);
            return $this->twig->render('Front/cart.html.twig', ["panier" => $panier, "price" => $price]);
        }
    }
}

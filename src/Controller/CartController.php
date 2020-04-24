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
            $class = "hidden";
            $panier="";
        } else {
            $class = "";
            $panier = $_SESSION['id_panier'];
        }
        return $this->twig->render(
            'Front/index.html.twig',
            ["bouquets" => $bouquets, "class" => $class, "panier" => $panier]
        );
    }


    public function addBouquetCart($idBouquet)
    {
        $cartManager = new CartManager();
        $user['id_user'] = ($_SESSION['user']);

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

    public function showCart($id)
    {
        $cartManager = new CartManager();
        $panier = $cartManager->showCartContent($id);
        $price = $cartManager->priceCart($id);
        return $this->twig->render('Front/cart.html.twig', ["panier" => $panier, "price" => $price]);
    }
}

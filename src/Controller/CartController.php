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
        return $this->twig->render('Front/index.html.twig', ["bouquets" => $bouquets]);
    }

    public function addBouquetCart($id)
    {
        $cartManager = new CartManager();
        $user = ($_SESSION['user']);

        if (!isset($_SESSION['id_panier'])) {
            $id = $cartManager->insert($user);
            $_SESSION['id_panier'] =  $id;
            $cartManager->addBouquetCart($id);
        } else {
            $cartManager->addBouquetCart($id);
        }
        $bouquetManager= new BouquetManager();
        $bouquets = $bouquetManager->selectAll();
        return $this->twig->render('Front/index.html.twig', ["bouquets" => $bouquets]);
    }

    public function showCart($id)
    {
        $cartManager = new CartManager();
        $cart = $cartManager->showCartContent($id);
        return $this->twig->render('Front/index.html.twig', ["cart" => $cart]);
    }
}

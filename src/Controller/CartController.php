<?php


namespace App\Controller;

use App\Model\BouquetManager;
use App\Model\CartManager;
use App\Model\CartBouquetManager;
use DateTime;

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
            'Front/bouquets.html.twig',
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
            $cartBManager = new CartBouquetManager();
            $user = ($_SESSION['user']);
            $date = new DateTime("now");
            $date = $date->format("Y-m-d");

            $bouquetManager= new BouquetManager();
            $bouquets = $bouquetManager->selectAll();

            if (!isset($_SESSION['id_panier'])) {
                $id = $cartManager->insert($user, $date);
                $_SESSION['id_panier'] =  $id;
            }
            $panier = $_SESSION['id_panier'];
            if ($cartBManager->bouquetInCart($idBouquet, $panier) === false) {
                $cartBManager->addBouquetCart($idBouquet, $panier);
            } else {
                $qte = $cartBManager->selectQuantiteBouquet($idBouquet);
                $qte['quantite']= $qte['quantite'] + 1;
                $qte = $qte['quantite'];
                $cartBManager->updateBouquetCart($idBouquet, $qte);
                header("location: /Cart/showCart/$panier");
            }
            return $this->twig->render(
                'Front/bouquets.html.twig',
                ["bouquets" => $bouquets, "panier" => $panier]
            );
        }
    }

    public function showCart($id)
    {
        if (!isset($_SESSION['user'])) {
            $message = "Vous devez vous inscrire ou vous connecter pour commmander";
            return $this->twig->render('User/add.html.twig', ["message" => $message]);
        } else {
            $cartManager = new CartManager();
            $cartBManager = new CartBouquetManager();
            $panier = $cartManager->showCartContent($id);
            $priceB = $cartBManager->priceCartBouquet($id);
            $priceCart = $priceB;
            return $this->twig->render(
                'Front/cart.html.twig',
                ["panier" => $panier, "priceB" => $priceB, "priceCart" => $priceCart]
            );
        }
    }

    public function deleteBouquet(int $id)
    {
        $cartBManager = new CartBouquetManager();
        $qte = $cartBManager->selectQuantiteBouquet($id);
        $idpanier = $_SESSION['id_panier'];
        if ($qte['quantite'] > 1) {
            $newQte = $qte['quantite'] - 1;
            $qte['quantite'] = $newQte;
            $cartBManager->updateBouquetCart($id, $qte['quantite']);
            header("Location: /cart/showCart/" . $idpanier);
        } else {
            $cartBManager->delete($id);
            header("Location: /cart/showCart/" . $idpanier);
        }
    }
}

<?php

namespace App\Controller;

use App\Model\BouquetManager;
use App\Model\ConceptManager;
use App\Model\GalerieManager;
use App\Model\UserManager;

/**
 * Class FrontController
 * @package App\Controller
 * @SuppressWarnings(PHPMD)
 */
class FrontController extends AbstractController
{
    public function index()
    {
        $userManager = new UserManager();

        if (isset($_SESSION['user'])) {
            $user = $userManager->selectOneById($_SESSION['user']);
        } else {
            $user = null;
        }

        // Randomisation de 4 bouquets
        $bouquetManager = new BouquetManager();
        $galerieManager = new GalerieManager();

        $bouquets = $bouquetManager->selectAll();
        shuffle($bouquets);
        $bouquetsRand = [
            $bouquets[0],
            $bouquets[1],
            $bouquets[2],
            $bouquets[3]
        ];
        $images = $galerieManager->selectAll();

        return $this->twig->render('Front/index.html.twig', [
            'user' => $user,
            'bouquets' => $bouquetsRand,
            'images' => $images,
            ]);
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function bouquets()
    {
        $galerieManager = new GalerieManager();
        $bouquetManager= new BouquetManager();
        $bouquets = $bouquetManager->selectAll();
        $images = $galerieManager->selectAll();
        $saisonniers = $bouquetManager->saisonnier();

        if (!isset($_SESSION['id_panier'])) {
            $panier="";
        } else {
            $panier = $_SESSION['id_panier'];
        }
        return $this->twig->render(
            'Front/bouquets.html.twig',
            ["bouquets" => $bouquets,
                "panier" => $panier,
                "images"=>$images,
                "saisonniers"=>$saisonniers]
        );
    }

    public function filter(string $filter)
    {
        $bouquetManager = new BouquetManager();
        $bouquets = $bouquetManager->filter($filter);
        $saisonniers = $bouquetManager->saisonnier();
        return $this->twig->render(
            'Front/bouquets.html.twig',
            ['bouquets' => $bouquets, "saisonniers" => $saisonniers]
        );
    }

    public function contact()
    {
        $mailDestinataire = "franck7980@gmail.com";
        $nonEnvoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
        $messageEnvoye = "Votre message nous est bien parvenu !";
        if (!empty($_POST)) {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $objet = $_POST['objet'];
            $message = $_POST['message'];
            $from = "From: " . $nom . "<" . $email . "> \r\nMime-Version:\r\n";
            $from .= " 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n";

            if (($_POST['nom'] != '') && ($_POST['email'] != '')
                && ($_POST['objet'] != '') && ($_POST['message'] != '')) {
                $messageMail = "Formulaire de contact\r\n
              Nom : " . $nom . "<br>
              Email : " . $email . "<br><br>
              Objet : " . $objet . "<br>
              Message : " . $message . "";

                $result = mail($mailDestinataire, $objet, $messageMail, $from);
                if ($result == true) {
                    echo $messageEnvoye;
                }
            } else {
                echo $nonEnvoye;
            }
        }
            return $this->twig->render('Front/contact.html.twig');
    }

    public function aPropos()
    {
        return $this->twig->render('Front/apropos.html.twig');
    }

    public function questionsFrequentes()
    {
        return $this->twig->render('Front/faq.html.twig');
    }

    public function cgv()
    {
        return $this->twig->render('Front/conditions.html.twig');
    }

    public function mentionsLegales()
    {
        return $this->twig->render('Front/mentions.html.twig');
    }
}

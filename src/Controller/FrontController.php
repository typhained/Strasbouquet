<?php

namespace App\Controller;

use App\Model\BouquetManager;
use App\Model\ConceptManager;
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
        $conceptManager = new ConceptManager();
        $concepts = $conceptManager->selectAll();
        return $this->twig->render('Front/index.html.twig', ['concepts' => $concepts]);
    }

    public function show(int $id)
    {
        $conceptManager = new ConceptManager();
        $concept = $conceptManager->selectOneById($id);
        return $this->twig->render('Front/show.html.twig', ['concept' => $concept]);
    }
    public function filter(string $filter)
    {
        $bouquetManager = new BouquetManager();
        $bouquets = $bouquetManager->filter($filter);

        return $this->twig->render('Front/bouquets.html.twig', ['bouquets' => $bouquets]);
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
}

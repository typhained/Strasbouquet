<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll();

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }

    public function add()
    {
        $message="";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $message= "L'adresse mail est invalide";
                return $this->twig->render('User/add.html.twig', ['message'=>$message]);
            } else {
                $userManager = new UserManager();
                $user = [
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'password' => $_POST['password'],
                    'mail' => $_POST['mail'],
                    'tel' => $_POST['tel'],
                ];
                if ($userManager->checkEmail($user) === false) {
                    $userManager->insert($user);
                    header('Location:/User/index/');
                } else {
                    $message = "L'adresse mail est déjà enregistrée. 
                   Veuillez vous connecter ou tenter avec une autre adresse email.";
                    return $this->twig->render('User/add.html.twig', ['message'=>$message]);
                }
            }
        }
        return $this->twig->render('User/add.html.twig');
    }
}

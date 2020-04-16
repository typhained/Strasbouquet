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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $user = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastanme'],
                'password' => $_POST['password'],
                'mail' => $_POST['mail'],
                'tel' => $_POST['tel'],
                'role' => $_POST['role'],
            ];
            $id = $userManager->insert($user);
            header('Location:/item/show/' . $id);
        }

        return $this->twig->render('User/add.html.twig');
    }
}

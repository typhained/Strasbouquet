<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\AccountManager;

/**
 * Class ItemController
 *
 */
class AccountController extends AbstractController
{

    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('location:/Front/index/');
        } else {
            if ($_POST) {
                $account = new AccountManager();
                $mail = $_POST['mail'];
                $checkmdp = $account->checkmdp($mail);
                foreach ($checkmdp as $v) {
                    $mdp = $v['password'];
                    $role = $v['role'];
                    $id = $v['id'];
                    if (password_verify($_POST['password'], $mdp)) {
                        $_SESSION['user'] = $id;
                        $_SESSION['role'] = $role;
                        if ($_SESSION['role'] == 'admin') {
                            header('location:/Home/index/');
                        } else {
                            header('Location: /Front/index');
                        }
                    } else {
                        $message = "Le Mot de passe et l'adresse email ne correspondent pas.";
                        return $this->twig->render('Account/login.html.twig', ['message' => $message]);
                    }
                }
            }
            return $this->twig->render('Account/index.html.twig');
        }
    }


    public function logout()
    {
        session_destroy();
        header('location:/Front/index/');
    }
}

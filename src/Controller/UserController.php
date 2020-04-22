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
            $patternTel= '/^0[1-689][0-9]{8}$/';
            $patternPass='/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/' ;
            if (empty($_POST['firstname']) && empty($_POST['lastname'])) {
                $message= "Veuillez remplir les champs NOM et PRENOM s'il vous plaît";
                return $this->twig->render('User/add.html.twig', ['message'=>$message]);
            } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $message= "L'adresse mail est invalide";
                return $this->twig->render('User/add.html.twig', ['message'=>$message]);
            } elseif (!empty($_POST['tel']) && (preg_match($patternTel, $_POST['tel']) === 0)) {
                $message = "Il y a un problème avec le numéro de téléphone.";
                return $this->twig->render('User/add.html.twig', ['message' => $message]);
            } elseif (preg_match($patternPass, $_POST['password']) === 0) {
                $message= "Votre mot de passe doit faire minimum 6 caractères 
                et contenir au moins une majuscule et un chiffre";
                return $this->twig->render('User/add.html.twig', ['message'=>$message]);
            } else {
                $userManager = new UserManager();
                $user = [
                    'firstname' => ucfirst($_POST['firstname']),
                    'lastname' => strtoupper($_POST['lastname']),
                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                    'mail' => strtolower($_POST['mail']),
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


    public function update(int $id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patternPass = '/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
            if (preg_match($patternPass, $_POST['password']) === 0) {
                $message = "Votre mot de passe doit faire minimum 6 caractères 
                et contenir au moins une majuscule et un chiffre";
                return $this->twig->render('User/update.html.twig', ['user' => $user, 'message' => $message]);
            } else {
                $userManager = new UserManager();

                $user['firstname'] = ucfirst($_POST['firstname']);
                $user['lastname'] = strtoupper($_POST['lastname']);
                $user['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $user['mail'] = strtolower($_POST['mail']);
                $user['num_Tel'] = $_POST['tel'];

                $userManager->update($user);
                $message = "Votre compte a bien été mis à jour";
                return $this->twig->render('User/show.html.twig', ['user' => $user, 'message' => $message]);
            }
        }
        return $this->twig->render('User/update.html.twig', ['user' => $user]);
    }
    public function show(int $id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);
        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }

    public function delete(int $id)
    {
        $userManager = new UserManager();
        $userManager->delete($id);
        header('Location:/user/index');
    }
}

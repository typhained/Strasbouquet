<?php

namespace App\Controller;

use App\Model\BouquetManager;

class BouquetController extends AbstractController
{
    public function index()
    {

        if ($_SESSION['role'] == 'admin') {
            $bouquetManager = new BouquetManager();
            $bouquets = $bouquetManager->selectAll();

            return $this->twig->render('Bouquet/index.html.twig', ['bouquets' => $bouquets]);
        } else {
            header('location:/Front/index/');
        }
    }
    /**
     * Display user creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        if ($_SESSION['role'] == 'admin') {
            $message="";
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (strlen($_POST['description'])>249) {
                    $message = "votre déscription est trop longue!";
                    return $this->twig->render('Bouquet/add.html.twig', ['title'=>'créer un bouquet',
                        'message'=>$message]);
                } else {
                    $bouquetManager = new BouquetManager();
                    $bouquet = [
                        'nom' => $_POST['nom'],
                        'prix' => $_POST['prix'],
                        'description' => $_POST['description'],
                        'saisonnier' => $_POST['saisonnier'],
                    ];
                    $id = $bouquetManager->insert($bouquet);
                    header('Location:/bouquet/show/' . $id);
                }
            }
            return $this->twig->render('Bouquet/add.html.twig', ['title'=>'créer un bouquet']);
        } else {
            header('location:/Front/index/');
        }
    }

    public function show(int $id)
    {
        if ($_SESSION['role'] == 'admin') {
            $bouquetManager = new BouquetManager();
            $bouquet = $bouquetManager->selectOneById($id);

            return $this->twig->render('Bouquet/show.html.twig', ['bouquet' => $bouquet]);
        } else {
            header('location:/Front/index/');
        }
    }

    /**
     * Handle user deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        if ($_SESSION['role'] == 'admin') {
            $bouquetManager = new BouquetManager();
            $bouquetManager->delete($id);
            header('Location:/Bouquet/index');
        } else {
            header('location:/Front/index/');
        }
    }
    public function update(int $id): string
    {
        if ($_SESSION['role'] == 'admin') {
            $bouquetManager = new BouquetManager();
            $bouquet = $bouquetManager->selectOneById($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bouquet['nom'] = $_POST['nom'];
                $bouquet['prix'] = $_POST['prix'];
                $bouquet['description'] = $_POST['description'];
                $bouquet['saisonnier'] = $_POST['saisonnier'];
                $bouquetManager->update($bouquet);
                header('Location:/Bouquet/show/'. $id);
            }
            return $this->twig->render('Bouquet/edit.html.twig', ['bouquet' => $bouquet, 'title' => $bouquet['nom']]);
        } else {
            header('location:/Front/index/');
        }
    }
}

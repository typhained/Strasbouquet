<?php

namespace App\Controller;

use App\Model\CatalogueUManager;

/**
 * Class ItemController
 *
 */
class CatalogueUController extends AbstractController
{
    public function index()
    {
        if ($_SESSION['role'] == 'admin') {
            $catalogueUManager = new CatalogueUManager();
            $catalogueUs = $catalogueUManager->selectAll();
            return $this->twig->render('CatalogueU/index.html.twig', ['catalogueUs' => $catalogueUs]);
        } else {
            header('location:/Front/index/');
        }
    }

    public function show(int $id)
    {
        if ($_SESSION['role'] == 'admin') {
            $catalogueUManager = new CatalogueUManager();
            $catalogueU = $catalogueUManager->selectOneById($id);
            $catalogueU['prix'] = number_format($catalogueU['prix'], 2, '.', '');
            return $this->twig->render('CatalogueU/show.html.twig', ['catalogueU' => $catalogueU]);
        } else {
            header('location:/Front/index/');
        }
    }

    public function add()
    {
        if ($_SESSION['role'] == 'admin') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $catalogueUManager = new CatalogueUManager();
                if (empty($_POST['nom']) || !is_string($_POST['nom'])) {
                    $message = "Veuillez remplir correctement le champ NOM s'il vous plaît";
                    return $this->twig->render('CatalogueU/add.html.twig', ['message' => $message]);
                }
                if (empty($_POST['prix']) || !is_numeric($_POST['prix'])) {
                    $message = "Veuillez remplir correctement le champ Prix s'il vous plaît";
                    return $this->twig->render('CatalogueU/add.html.twig', ['message' => $message]);
                }
                $catalogueU = [
                    'nom' => $_POST['nom'],
                    'type' => $_POST['type'],
                    'prix' => $_POST['prix'],
                    'couleur' => $_POST['couleur'],
                ];
                $catalogueUManager->insert($catalogueU);
                header('Location:/CatalogueU/index');
            }
            return $this->twig->render('CatalogueU/add.html.twig');
        } else {
            header('location:/Front/index/');
        }
    }

    public function update(int $id): string
    {
        if ($_SESSION['role'] == 'admin') {
            $catalogueUManager = new CatalogueUManager();
            $catalogueU = $catalogueUManager->selectOneById($id);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (empty($_POST['nom']) || !is_string($_POST['nom'])) {
                    $message = "Veuillez remplir correctement le champ NOM s'il vous plaît";
                    return $this->twig->render('CatalogueU/edit.html.twig', ['message' => $message]);
                }
                if (empty($_POST['prix']) ||
                    !is_numeric($_POST['prix'])) {
                    $message = "Veuillez remplir correctement le champ Prix s'il vous plaît";
                    return $this->twig->render('CatalogueU/edit.html.twig', ['message' => $message]);
                }
                $catalogueU['nom'] = $_POST['nom'];
                $catalogueU['type'] = $_POST['type'];
                $catalogueU['prix'] = number_format($_POST['prix'], 2, ".", "");
                $catalogueU['couleur'] = $_POST['couleur'];
                $catalogueUManager->update($catalogueU);
                header('Location:/CatalogueU/index');
            }
            return $this->twig->render('CatalogueU/edit.html.twig', ['catalogueU' => $catalogueU]);
        } else {
            header('location:/Front/index/');
        }
    }

    public function delete(int $id)
    {
        if ($_SESSION['role'] == 'admin') {
            $catalogueUManager = new CatalogueUManager();
            $catalogueUManager->delete($id);
            header('Location:/CatalogueU/index');
        } else {
            header('location:/Front/index/');
        }
    }
}

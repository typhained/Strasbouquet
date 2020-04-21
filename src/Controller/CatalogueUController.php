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
        $catalogueUManager = new CatalogueUManager();
        $catalogueUs = $catalogueUManager->selectAll();

        return $this->twig->render('CatalogueU/index.html.twig', ['catalogueUs' => $catalogueUs]);
    }

    public function show(int $id)
    {
        $catalogueUManager = new CatalogueUManager();
        $catalogueU = $catalogueUManager->selectOneById($id);

        return $this->twig->render('CatalogueU/show.html.twig', ['catalogueU' => $catalogueU]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catalogueUManager = new CatalogueUManager();

            if (empty($_POST['nom']) || !preg_match("/^[a-zA-Z ]*$/", $_POST['nom'])) {
                $message = "Veuillez remplir correctement le champ NOM s'il vous plaît";

                return $this->twig->render('CatalogueU/add.html.twig', ['message' => $message]);
            }

            if (empty($_POST['prix']) ||
                !preg_match("/^([1-9][0-9]{,2}(,[0-9]{3})*|[0-9]+)(\.[0-9]{1,9})?/", $_POST['prix'])) {
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
    }

    public function edit(int $id): string
    {
        $catalogueUManager = new CatalogueUManager();
        $catalogueU = $catalogueUManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['nom']) || !preg_match("/^[a-zA-Z ]*$/", $_POST['nom'])) {
                $message = "Veuillez remplir correctement le champ NOM s'il vous plaît";

                return $this->twig->render('CatalogueU/edit.html.twig', ['message' => $message]);
            }

            if (empty($_POST['prix']) ||
                !preg_match("/^([1-9][0-9]{,2}(,[0-9]{3})*|[0-9]+)(\.[0-9]{1,9})?/", $_POST['prix'])) {
                $message = "Veuillez remplir correctement le champ Prix s'il vous plaît";

                return $this->twig->render('CatalogueU/edit.html.twig', ['message' => $message]);
            }
            $catalogueU['nom'] = $_POST['nom'];
            $catalogueU['type'] = $_POST['type'];
            $catalogueU['prix'] = $_POST['prix'];
            $catalogueU['couleur'] = $_POST['couleur'];
            $catalogueUManager->update($catalogueU);
            header('Location:/CatalogueU/index');
        }

        return $this->twig->render('CatalogueU/edit.html.twig', ['catalogueU' => $catalogueU]);
    }


    public function delete(int $id)
    {
        $catalogueUManager = new CatalogueUManager();
        $catalogueUManager->delete($id);
        header('Location:/CatalogueU/index');
    }
}

<?php

namespace App\Controller;

use App\Model\CatalogueUManager;
use App\Model\GalerieManager;
use spec\GrumPHP\Task\AntSpec;

/**
 * Class ItemController
 * @SuppressWarnings(PHPMD)
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
//                $catalogueU['prix'] = number_format($catalogueU['prix'], 2, '.', '');
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
                    'nom' => ucfirst($_POST['nom']),
                    'type' => $_POST['type'],
                    'prix' => $_POST['prix'],
                    'couleur' => $_POST['couleur'],
                ];
                $galerieManager = new GalerieManager();
                $targetDir = "assets/uploads/";
                $image = $_FILES['fileToUpload']['name'];
                $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                $targetFile = $targetDir . uniqid() . '.' . $imageFileType;
                $uploadOk = 1;
                $id = $catalogueUManager->insert($catalogueU);
                $galerieManager->insertCatalogueU($targetFile, $catalogueU, $id);

                if (file_exists($targetFile)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                if ($_FILES["fileToUpload"]["size"] > 1000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                if (($imageFileType != "jpg") && ($imageFileType != "png") && ($imageFileType != "jpeg")) {
                    echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                    $uploadOk = 0;
                }
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);
                header('Location:/CatalogueU/show/' . $id);
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
            $galerieManager = new GalerieManager();
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
                $catalogueU['id_cat'] = $_POST['id_cat'];
                $catalogueU['nom'] = $_POST['nom'];
                $catalogueU['type'] = $_POST['type'];
                $catalogueU['prix'] = number_format($_POST['prix'], 2, ".", "");
                $catalogueU['couleur'] = $_POST['couleur'];
                $type = "catalogue_unitaire";
                $galerieManager->update($id, $type, $catalogueU['nom']);
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
            $galerieManager = new GalerieManager();
            $galerieManager->deleteCatalogueU($id);
            $catalogueUManager->delete($id);
            header('Location:/CatalogueU/index');
        } else {
            header('location:/Front/index/');
        }
    }
}

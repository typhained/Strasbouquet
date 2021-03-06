<?php

namespace App\Controller;

use App\Model\BouquetManager;
use App\Model\GalerieManager;

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
                    return $this->twig->render(
                        'Bouquet/add.html.twig',
                        ['title'=>'créer un bouquet','message'=>$message]
                    );
                } else {
                    $galerieManager = new GalerieManager();
                    $targetDir = "assets/uploads/";
                    $image = $_FILES['fileToUpload']['name'];
                    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                    $targetFile = $targetDir . uniqid(). '.' . $imageFileType;
                    $uploadOk = 1;
                    $bouquetManager = new BouquetManager();
                    $bouquet = [
                        'nom' => $_POST['nom'],
                        'prix' => $_POST['prix'],
                        'description' => $_POST['description'],
                        'saisonnier' => $_POST['saisonnier'],
                    ];
                    $id = $bouquetManager->insert($bouquet);
                    $bouquet = $bouquetManager->selectOneById($id);
                    $galerieManager->insertBouquet($targetFile, $bouquet);
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
                    header('Location:/bouquet/show/' . $id);
                }
            }
            return $this->twig->render('Bouquet/add.html.twig', ['title'=>'créer un bouquet']);
        } else {
            header('location:/Front/index/');
        }
    }

    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        if ($_SESSION['role'] == 'admin') {
            $bouquetManager = new BouquetManager();
            $bouquet = $bouquetManager->selectOneById($id);
            $galerieManager = new GalerieManager();
            $image = $galerieManager->selectImageBouquet($id);
            return $this->twig->render('Bouquet/show.html.twig', ['bouquet' => $bouquet, 'image' => $image]);
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
            $galerieManager = new GalerieManager();
            $galerieManager->deleteBouquet($id);
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
    public function filter(string $filter)
    {
        $bouquetManager = new BouquetManager();
        $bouquets = $bouquetManager->filter($filter);

        return $this->twig->render('Bouquet/index.html.twig', ['bouquets' => $bouquets]);
    }
}

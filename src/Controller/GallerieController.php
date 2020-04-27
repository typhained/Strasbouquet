<?php

namespace App\Controller;

use App\Model\GallerieManager;

class GallerieController extends AbstractController
{
    public function index()
    {
        $gallerieManager = new GallerieManager();
        $galleries = $gallerieManager->selectAll();

        return $this->twig->render('Gallerie/index.html.twig', ['gallerie' => $galleries]);
    }
    
    /**
     * Display user creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function show(int $id)
    {
        $gallerieManager = new GallerieManager();
        $gallerie = $gallerieManager->selectImageBouquet($id);

        return $this->twig->render('Gallerie/show.html.twig', ['gallerie' => $gallerie]);
    }

    /**
     * Handle user deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $gallerieManager = new GallerieManager();
        $gallerieManager->delete($id);
        header('Location:/Gallerie/index');
    }
//    public function update(int $id): string
//    {
//        $gallerieManager = new GallerieManager();
//        $gallerie = $gallerieManager->selectOneImage($id);
//
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $gallerie['nom'] = $_POST['nom'];
//            $gallerie['file1'] = $_POST['file1'];
//            $gallerie['file2'] = $_POST['file2'];
//            $gallerieManager->update($gallerie);
//            header('Location:/Gallerie/show/'. $id);
//        }
//        return $this->twig->render('Gallerie/edit.html.twig', ['gallerie' => $gallerie, 'title' => $gallerie['nom']]);
//    }
    public function upload()
    {
        $targetDir = "";
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 1000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if (($imageFileType != "jpg") && ($imageFileType != "png") && ($imageFileType != "jpeg")) {
            echo "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                echo "The file ". basename($_FILES['fileToUpload']['name']). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

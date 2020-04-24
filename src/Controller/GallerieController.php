<?php

namespace App\Controller;

use App\Model\GallerieManager;

class GallerieController extends AbstractController
{
    
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
        $gallerie = $gallerieManager->selectOneImage($id);

        return $this->twig->render('Gallerie/show.html.twig', ['gallerie' => $gallerie]);
    }

    /**
     * Handle user deletion
     *
     * @param int $id
     */
//    public function delete(int $id)
//    {
//        $gallerieManager = new GallerieManager();
//        $gallerieManager->delete($id);
//        header('Location:/Gallerie/index');
//    }
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
}

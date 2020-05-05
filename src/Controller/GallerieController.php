<?php

namespace App\Controller;

use App\Model\GallerieManager;
use App\Model\BouquetManager;

class GallerieController extends AbstractController
{
    public function index()
    {
        $gallerieManager = new GallerieManager();
        $galleries = $gallerieManager->selectAll();

        return $this->twig->render('Gallerie/index.html.twig', ['galleries' => $galleries]);
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
        $image = $gallerieManager->selectImageBouquet($id);

        return $this->twig->render('Gallerie/show.html.twig', ['image' => $image]);
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
}

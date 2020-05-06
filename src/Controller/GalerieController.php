<?php

namespace App\Controller;

use App\Model\GalerieManager;

class GalerieController extends AbstractController
{
    public function index()
    {
        if ($_SESSION['role'] == 'admin') {
            $galerieManager = new GalerieManager();
            $galeries = $galerieManager->selectAll();
            return $this->twig->render('Galerie/index.html.twig', ['galeries' => $galeries]);
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

    public function show(int $id)
    {
        if ($_SESSION['role'] == 'admin') {
            $galerieManager = new GalerieManager();
            $image = $galerieManager->selectImageBouquet($id);
            return $this->twig->render('Galerie/show.html.twig', ['image' => $image]);
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
            $galerieManager->delete($id);
            header('Location:/Galerie/index');
        } else {
            header('location:/Front/index/');
        }
    }
}

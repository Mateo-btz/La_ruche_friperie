<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Entity\Collections;
use App\Entity\Images;
use App\Form\CollectionsType;
use App\Repository\CollectionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



    /**
     * @Route("/admin/collections", name="admin_collections_")
     * @package App\Controller\Admin
     */
    class CollectionsController extends AbstractController
    {

    /**
     * @Route("/", name="home")
     */
    public function index(CollectionsRepository $CollectionsRepo): Response
    {
        return $this->render('admin/collections/index.html.twig', [
            'collections' => $CollectionsRepo->findAll()
        ]);
    }
}

?>
<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Entity\Collections;
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

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function ModifCollections(Collections $collections, Request $request): Response
    {

        $form = $this->createForm(CollectionsType::class, $collections);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($collections);
            $em->flush();

            return $this->redirectToRoute('admin_collections_home');
        }

        return $this->render('admin/collections/ajout.html.twig', [
            'form' => $form->createView()

        ]);
    }
}

?>
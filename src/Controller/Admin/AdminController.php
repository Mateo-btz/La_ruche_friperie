<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Entity\Collections;
use App\Form\CollectionsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



    /**
     * @Route("/admin", name="admin_")
     * @package App\Controller\Admin
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }



        /**
     * @Route("/collections/ajout", name="collections_ajout")
     */
    public function ajoutCollection(Request $request): Response
    {
        $collection = new Collections;

        $form = $this->createForm(CollectionsType::class, $collection);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($collection);
            $em->flush();
            return $this->redirectToRoute('admin_home');
        }


        return $this->render('admin/collections/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/collections/supprimer/{id}", name="collections_supprimer")
     */
    public function Supprimer(Collections $collections)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($collections);
            $em->flush();

            $this->addFlash('message', 'Collection supprimée avec succès');
            return $this->redirectToRoute('admin_collections_home');
    }

}

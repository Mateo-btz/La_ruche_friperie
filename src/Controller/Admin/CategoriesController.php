<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Entity\Collections;
use App\Form\CollectionsType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



    /**
     * @Route("/admin/categories", name="admin_categories_")
     * @package App\Controller\Admin
     */
    class CategoriesController extends AbstractController
    {

    /**
     * @Route("/", name="home")
     */
    public function index(CategoriesRepository $CategoriesRepo): Response
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $CategoriesRepo->findAll()
        ]);
    }



    /**
     * @Route("/ajout", name="ajout")
     */
    public function AjoutCategorie(Request $request): Response
    {
 
        $categorie = new Categories;

        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('admin_categories_home');
        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()

        ]);
    }

        /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function ModifCategorie(Categories $categorie, Request $request): Response
    {

        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('admin_categories_home');
        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()

        ]);
    }

        /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function Supprimer(Categories $categories, Request $request) : Response
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categories);
            $em->flush();

            $this->addFlash('message', 'Collection supprimée avec succès');
            return $this->redirectToRoute('admin_categories_home');
    }

}

?>
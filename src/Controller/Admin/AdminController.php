<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Images;
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
            // Récuperation des images
            $images = $form->get('images')->getData();

            // On boucle les img
            foreach($images as $image){
               // on génère un nouveau nom de ficher
               $fichier = md5(uniqid()) . '.' . $image->guessExtension();
               //copie du fichier dans le dossier upload
               $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
               );
               // stockage de l'image dans la bdd
               $img = new Images();
               $img->setName($fichier);
               $collection->addImage($img);
            }

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
     * @Route("collections/modifier/{id}", name="collections_modifier")
     */
    public function ModifCollections(Collections $collections, Request $request): Response
    {
        $form = $this->createForm(CollectionsType::class, $collections);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Récuperation des images
            $images = $form->get('images')->getData();

            // On boucle les img
            foreach($images as $image){
               // on génère un nouveau nom de ficher
               $fichier = md5(uniqid()) . '.' . $image->guessExtension();
               //copie du fichier dans le dossier upload
               $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
               );
               // stockage de l'image dans la bdd
               $img = new Images();
               $img->setName($fichier);
               $collections->addImage($img);
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($collections);
            $em->flush();

            return $this->redirectToRoute('admin_collections_home');
        }

        return $this->render('admin/collections/ajout.html.twig', [
            'form' => $form->createView()

        ]);
    }


    /**
     * @Route("/collections/supprimer/{id}", name="collections_supprimer")
     */
    public function Supprimer(Collections $collections, Request $request) : Response
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($collections);
            $em->flush();

            $this->addFlash('message', 'Collection supprimée avec succès');
            return $this->redirectToRoute('admin_collections_home');
    }

    /**
    * @Route("/supprimer/image/{id}", name="collections_supprimer_image", methods={"DELETE"})
    */
    public function DeleteImage(Images $image, Request $request){
        $data = json_decode($request->getContent(), true);

        // Vérification du token
        if($this->isCsrfTokenValid('delete' .$image->getId(), $data['_token'])){
        // Récuperation du nom de l'img
            $nom = $image->getName();
            unlink($this->getParameter('images_directory').'/'.$nom);

            // suppression de la bdd
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // réponse en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 500);
        }
    }
}

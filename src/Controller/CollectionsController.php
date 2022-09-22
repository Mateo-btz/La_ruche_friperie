<?php

namespace App\Controller;

use DateTime;
use App\Entity\Collections;
use App\Entity\Comments;
use App\Entity\Users;
use App\Form\CommentsType;
use App\Repository\CollectionsRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @Route("collections", name="collections_")
 * @package App\Controller
 */
class CollectionsController extends AbstractController
{
    /**
     * @Route("/details/{title}", name="details")
     */
    public function details($title, CollectionsRepository $collectionsRepo, Request $request)
    {
        $collection = $collectionsRepo->findOneBy(['title' => $title]);
        
        if(!$collection){
            throw new NotFoundHttpException('Pas de collection trouvée');
        }

        // return $this->render('collections/details.html.twig', compact('collection'));



        $comment = new Comments;
        $user = $this->getUser();
        $commentForm = $this->createForm(CommentsType::class, $comment);
    
        $commentForm->handleRequest($request);

        if($user && $commentForm->isSubmitted() && $commentForm->isValid()){

            $comment->setCreatedAt(new DateTime());
            $comment->setCollections($collection);
            $comment->setUsers($user);
             
            // on récupère le contenu du champ parentid
            $parentid = $commentForm->get("parentid")->getData();


            $em = $this->getDoctrine()->getManager();
            $parent = $em->getRepository(Comments::class)->find($parentid);
           

            // On définit le parent
            $comment->setParent($parent);
            
            $em->persist($comment);
            $em->flush();

            $this->addFlash('message', 'votre commentaire a bien été envoyé');
            return $this->redirectToRoute('collections_details', ['title' =>
            $collection->getTitle()]);
        } elseif (!$user){
            $this->addFlash('message', 'vous devez vous connecter pour laisser un commentaire');
        }

    
        return $this->render('collections/details.html.twig', [
            'collection' => $collection,
            'user' => $user,
            'commentForm' => $commentForm->createView()
        ]);
    }
}



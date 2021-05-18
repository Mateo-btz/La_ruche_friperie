<?php

namespace App\Controller;

use App\Entity\Collections;
use App\Repository\CollectionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function details($title, CollectionsRepository $collectionsRepo)
    {
        $collection = $collectionsRepo->findOneBy(['title' => $title]);
        
        if(!$collection){
            throw new NotFoundHttpException('Pas de collection trouvée');
        }

        return $this->render('collections/details.html.twig', compact('collection'));
    }
}

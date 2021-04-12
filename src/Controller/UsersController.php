<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }

    /**
    * @Route("/users/profil/modifier", name="users_profil_modifier")
    */
    public function editProfile(Request $request) {

    $user = $this->getUser();
    $form = $this->createForm(EditProfileType::class, $user);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('message', 'Profil mis à jour');
        return $this->redirectToRoute('users');
    }

    return $this->render('users/editprofile.html.twig', [
        'form' => $form->createView()
    ]);

    }


        /**
    * @Route("/users/password/modifier", name="users_password_modifier")
    */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
    

        if($request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            if($request->request->get('password') == $request->request->get('confirmpassword')){
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $em->flush();
            $this->addFlash('message', 'Mot de passe mis à jour avec succès');

            return $this->redirectToRoute('users');

            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('users/editpassword.html.twig');
    
        }
}

<?php

namespace App\Controller;


use App\Entity\User;
use App\Exception\NonAuthorizedModification;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends ConcertController
{
    /**
     * @Route("/user/create", name="user_create")
     * @param Request $request
     * @param UserPasswordEncoder $userPasswordEncoder
     * @return Response
     * @throws NonAuthorizedModification
     */
    public function createUser(Request $request,UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        if($request->get('id')){
            if($this->getUser()->getId() != $request->get('id')){
                throw new NonAuthorizedModification();
            }
            $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($request->get('id'));
        }
        else{
            $user = new User();
        }

        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $user->setPassword($userPasswordEncoder->encodePassword($user,$user->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/new.html.twig',[
            "form" => $form->createView()
        ]);
    }

}
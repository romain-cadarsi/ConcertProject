<?php
namespace App\Controller;

use App\Entity\Band;
use App\Entity\Member;
use App\Entity\Picture;
use App\Form\BandType;
use App\Form\MemberType;
use App\Repository\BandRepository;
use App\Service\ImageUploadService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends ConcertController
{

    /**
     * @Route("/member/view/{id}", name="memberView" , methods={"GET"})
     */
    public function memberView($id): Response
    {
        $member = $this->getDoctrine()->getRepository(Member::class)->find($id);
        return $this->render('concert/pages/member/view.html.twig',[
            "member" => $member
        ]);
    }

    /**
     * @Route("/member/create", name="memberCreate")
     */
    public function createMember(Request $request, ImageUploadService $imageUploadService): Response
    {
        if($request->get('id')){
            $member = $this->getDoctrine()->getManager()->getRepository(Member::class)->find($request->get('id'));
        }
        else{
            $member = new Member();
        }

        $form = $this->createForm(MemberType::class,$member);



        $form->handleRequest($request);

        if($form->isSubmitted()){

            $pictureElement = $form->get('picture')->getData();
            $pictureEntity = $imageUploadService->uploadImage($pictureElement);
            $member = $form->getData();
            $member->setPicture($pictureEntity);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->persist($pictureEntity);
            $entityManager->flush();
            return $this->redirectToRoute('memberView',
                ['entityID' => $member->getId()
                ]);
        }

        return $this->render('concert/pages/member/new.html.twig',[
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/member/delete/{id}", name="memberDelete" , methods={"GET"})
     */
    public function memberDelete($id): Response
    {
        $entityManager =  $this->getDoctrine()->getManager();
        $memberRepository = $this->getDoctrine()->getRepository(Member::class);
        $member = $memberRepository->find($id);
        $entityManager->remove($member);
        $entityManager->flush();

        return $this->redirectToRoute('bandList');
    }


}
<?php
namespace App\Controller;

use App\Entity\Band;
use App\Entity\Picture;
use App\Entity\Show;
use App\Form\BandType;
use App\Repository\BandRepository;
use App\Service\ImageUploadService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BandController extends ConcertController
{

    /**
     * @Route("/band/list", name="bandList")
     */
    public function bandList(): Response
    {
        $bands = $this->getDoctrine()->getRepository(Band::class)->findAll();
        return $this->render('concert/pages/band/list.html.twig',[
            "groupes" => $bands
        ]);
    }


    /**
     * @Route("/band/view/{id}", name="bandView" , methods={"GET"})
     */
    public function bandView($id): Response
    {
        $showRepository = $this->getDoctrine()->getRepository(Show::class);
        $bandRepository = $this->getDoctrine()->getRepository(Band::class);
        $band = $bandRepository->find($id);
        $nextConcerts = $showRepository->nextShowsForThisBand($id);
        return $this->render('concert/pages/band/view.html.twig',[
            "groupe" => $band,
            'nextConcerts' => $nextConcerts
        ]);
    }

    /**
     * @Route("/band/create", name="bandCreate")
     */
    public function createBand(Request $request,ImageUploadService $imageUploadService): Response
    {
        if($request->get('id')){
        $band = $this->getDoctrine()->getManager()->getRepository(Band::class)->find($request->get('id'));
        }
        else{
            $band = new Band();
        }


        $form = $this->createForm(BandType::class,$band);



        $form->handleRequest($request);

        if($form->isSubmitted()){

            $pictureElement = $form->get('picture')->getData();
            $pictureEntity = $imageUploadService->uploadImage($pictureElement);
            $band = $form->getData();
            $band->setPicture($pictureEntity);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($band);
            $entityManager->persist($pictureEntity);
            $entityManager->flush();
            return $this->redirectToRoute('bandView',
                ['id' => $band->getId()
                ]);
        }

        return $this->render('concert/pages/band/new.html.twig',[
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/band/delete/{id}", name="bandDelete" , methods={"GET"})
     */
    public function bandDelete($id): Response
    {
        $entityManager =  $this->getDoctrine()->getManager();
        $bandRepository = $this->getDoctrine()->getRepository(Band::class);
        $band = $bandRepository->find($id);
        $entityManager->remove($band);
        $entityManager->flush();

        return $this->redirectToRoute('bandList'
          );
    }



}
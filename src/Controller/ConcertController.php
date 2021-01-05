<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\Show;
use App\Form\ConcertType;
use App\Form\UserType;
use App\Repository\ShowRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class ConcertController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function concertList(): Response
    {
        $showRepository =  $this->getDoctrine()->getManager()->getRepository(Show::class);
        $nextShow = $showRepository->nextShows();
        $oldShows = $showRepository->oldShows();
        return $this->render('concert/pages/concert/list.html.twig',[
            "newConcerts" => $nextShow,
            "oldShows" => $oldShows
        ]);
    }

    /**
     * @Route("/concert/create", name="concertCreate")
     */
    public function createConcert(Request $request): Response
    {
        if($request->get('id')){
            $show = $this->getDoctrine()->getManager()->getRepository(Show::class)->find($request->get('id'));
        }
        else{
            $show = new Show();
        }

        $form = $this->createForm(ConcertType::class,$show);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $show = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($show);
            $entityManager->flush();
            return $this->redirectToRoute('home',
                ['id' => $show->getId()
                ]);
        }

        return $this->render('concert/pages/concert/new.html.twig',[
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/concert/delete/{id}", name="concertDelete" , methods={"GET"})
     */
    public function concertDelete($id): Response
    {
        $entityManager =  $this->getDoctrine()->getManager();
        $concertRepository = $this->getDoctrine()->getRepository(Show::class);
        $concert = $concertRepository->find($id);
        $entityManager->remove($concert);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }


    }

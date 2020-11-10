<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends AbstractController
{
    /**
     * @Route("/concert", name="concert")
     */
    public function index(): Response
    {
        return $this->render('concert/pages/index.html.twig', [
            'controller_name' => 'ConcertController',
        ]);
    }

    /**
     * @Route("/list", name="liste")
     */
    public function liste(): Response
    {
        $concerts = [
            ['artiste' => "Lorie 💛",
                'description' => "La plus belle",
                "image" => "image/lorie.jpg"],
            ["artiste" => "PLK 🐻" ,
                "description" => "Sah avec son ours il fait des ravages ce jeune",
                "image" => "image/plk.jpg"],
            ["artiste" => "Crazy Frog 👽",
                "description" => "Ta ta, ta talata ta ta ta, ta talata ta tatata tala tala tataaaaa",
                "image" => "image/crazyFrog.jpg"],
            ["artiste" => "Aya Nakamura ✌️",
                "description" => "Chui pas ta catain djadja ",
                "image" => "image/ayana.webp"]
    ];


        return $this->render('concert/pages/list.html.twig', [
            'concerts' => $concerts,
        ]);
    }
}

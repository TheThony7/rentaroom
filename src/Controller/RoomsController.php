<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomsController extends AbstractController
{
    #[Route('/rooms', name: 'app_rooms')]
    public function index(RoomRepository $repo): Response
    {

        $liste = $repo->findAll();
        return $this->render('rooms/rooms.html.twig', [
            'liste_twig' => $liste,
        ]);
    }
}

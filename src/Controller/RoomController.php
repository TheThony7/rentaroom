<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    // Route qui affiche une note en particulier
    #[Route('/room/{id}', name: 'app_room', methods: ['GET', 'POST'])]
    public function show($id, RoomRepository $oneRoom): Response
    {
        // Affiche la note demandée dans le template dédié
        return $this->render('room/room.html.twig', [
            // Récupère la note demandée par son id
            'oneRoom' => $oneRoom->findOneBy(
                ['id' => $id]
            ),
    ]);
}
}
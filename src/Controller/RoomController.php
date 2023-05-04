<?php

namespace App\Controller;

use App\Repository\MaterialRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    // Route qui affiche une salle en particulier
    #[Route('/room/{id}', name: 'app_room', methods: ['GET', 'POST'])]
    public function show($id, RoomRepository $oneRoom, MaterialRepository $material): Response
    {
        // Affiche la salle demandée dans le template dédié
        return $this->render('room/room.html.twig', [
            // Récupère la salle demandée par son id
            'oneRoom' => $oneRoom->findOneBy(
                ['id' => $id]
            ),
            'material' => $material->findAll()
            
            ]);
    }
}
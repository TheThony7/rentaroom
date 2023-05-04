<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MesreservationsController extends AbstractController
{
    #[Route('/mesreservations', name: 'app_mesreservations')]


    public function mesReservations(ManagerRegistry $doctrine)
    {
        $user = $this->getUser(); // Obtenez l'utilisateur connecté
        $reservations = $doctrine->getRepository(Reservation::class)->findBy(['user' => $user]);

        return $this->render('mesreservations/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    // Route qui permet de supprimer une réservation
    #[Route('reservation/{id}/delete', name: 'delete_reservation', methods: ['GET', 'POST'])]
    public function delete(Reservation $reservation, ManagerRegistry $doctrine): Response
    {
        // Vérifier que l'utilisateur connecté est bien propriétaire de la réservation
        if ($reservation->getUser() !== $this->getUser()) {
            throw new AccessDeniedException();
        }

        // Supprimer la réservation
        $entityManager = $doctrine->getManager();
        $entityManager->remove($reservation);
        $entityManager->flush();

        // Rediriger l'utilisateur vers la page des reservations
        return $this->render('mesreservations/success_delete.html.twig');
    }


    #[Route('reservation/{id}/edit', name: 'edit_reservation', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ManagerRegistry $doctrine): Response
    {
        // Vérifier que l'utilisateur connecté est bien propriétaire de la réservation
        if ($reservation->getUser() !== $this->getUser()) {
            throw new AccessDeniedException();
        }

            // Créer le formulaire d'édition de réservation
            $form = $this->createFormBuilder($reservation)
                ->add('startDate', DateTimeType::class, ['label' => 'Date de début'])
                ->add('endDate', DateTimeType::class, ['label' => 'Date de fin'])
                ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
                ->getForm();

            // Traitement du formulaire d'édition
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $doctrine->getManager();
                $entityManager->flush();

                return $this->render('mesreservations/success_update.html.twig');
        }

        return $this->render('mesreservations/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);

}
}
    // // Route qui permet de supprimer une note
    // #[Route('note/delete', name: 'delete_note', methods: ['GET', 'POST'])]
    // public function deleteNote(ReservationRepository $repo): void
    // {
    // }


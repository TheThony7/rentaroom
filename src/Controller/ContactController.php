<?php

namespace App\Controller;

use PharIo\Manifest\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from($data['email'])
                ->to('anthony.desa88@gmail.com')
                ->subject('Nouveau message de votre site web')
                ->text('Expéditeur: '.$data['name'].' '.$data['email']."\n\n".$data['message']);

            $mailer->send($email);

            // Redirigez l'utilisateur vers une page de confirmation
            // return $this->redirectToRoute('confirmation');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
        }

        public function confirmation(): Response
        {
            return $this->render('contact/confirmation.html.twig');
        }
}


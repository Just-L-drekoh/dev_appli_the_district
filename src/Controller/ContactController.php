<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData(); // Récupère l'objet Contact à partir des données du formulaire

            // Utilisez les propriétés de l'objet Contact pour créer l'email
            $email = (new Email())
                ->from($contact->getEmail())
                ->to('you@example.com')
                ->subject('Nouveau message de contact')
                ->text('Nom: ' . $contact->getNom() . "\n" . 'Email: ' . $contact->getEmail() . "\n" . 'Message: ' . $contact->getDemande());

            $mailer->send($email);

            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView(),
        ]);
    }
}

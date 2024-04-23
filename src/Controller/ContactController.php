<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    #[IsGranted("ROLE_USER")]
    public function contact(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $data_mail = new Contact();
        $form = $this->createForm(ContactFormType::class, $data_mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($data_mail);
            $em->flush();


            $email = (new TemplatedEmail())
                ->from($data_mail->getEmail())
                ->to('The_District@gmail.com')
                ->subject('Demande de contact')
                ->htmlTemplate('contact/mail.html.twig')
                ->context(['data_mail' => $data_mail]);

            $mailer->send($email);


            $emailConfirmation = (new Email())
                ->from('The_District@gmail.com')
                ->to($data_mail->getEmail())
                ->subject('Confirmation de votre demande de contact')
                ->text('Merci pour votre demande de contact. Nous avons bien reçu vos informations.');

            $mailer->send($emailConfirmation);

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

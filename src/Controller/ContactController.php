<?php

namespace App\Controller;


use App\Service\MailService;
use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{

    #[Route('/contact', name: 'app_contact')]
    public function mail(Request $request, MailService $ms)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $ms->sendEmail($data);
            $ms->sendEmailConfirmation($data);
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

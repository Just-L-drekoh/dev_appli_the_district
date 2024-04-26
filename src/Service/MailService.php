<?php

namespace App\Service;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class MailService
{
    private $mailer;
    private $formFactory;
    private $entityManager;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($message): void
    {
        $this->mailer->send($message);
    }
}

<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(Contact $data): void
    {
        $email = (new TemplatedEmail())
            ->from($data->getEmail())
            ->to('The_District@gmail.com')
            ->subject('Demande de contact')
            ->htmlTemplate('contact/mail.html.twig')
            ->context(['data_mail' => $data]);

        $this->mailer->send($email);
    }

    public function sendEmailConfirmation(Contact $data): void
    {


        $emailConfirmation = (new Email())
            ->from('The_District@gmail.com')
            ->to($data->getEmail())
            ->subject('Confirmation de votre demande de contact')
            ->text('Merci pour votre demande de contact. Nous avons bien reçu vos informations.');

        $this->mailer->send($emailConfirmation);
    }
}

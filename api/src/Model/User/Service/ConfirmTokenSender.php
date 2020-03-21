<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\Email;
use Symfony\Component\Mime;
use Symfony\Component\Mailer\MailerInterface;

class ConfirmTokenSender
{
    private MailerInterface $mailer;
    private Mime\Email $message;
    private Mime\Address $from;

    public function __construct(MailerInterface $mailer, Mime\Email $message, Mime\Address $from)
    {
        $this->mailer = $mailer;
        $this->message = $message;
        $this->from = $from;
    }

    public function send(Email $email, string $token): void
    {
        $this->message
            ->from($this->from)
            ->to($email->getValue())
            ->subject('SignUp Confirmation')
            ->text('Token: '.$token);

        $this->mailer->send($this->message);
    }
}

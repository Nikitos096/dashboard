<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\ResetToken;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime;

class ResetTokenSender
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

    public function send(Email $email, ResetToken $token): void
    {
        $this->message
            ->from($this->from)
            ->to($email->getValue())
            ->text('Token: '.$token->getToken());

        $this->mailer->send($this->message);
    }
}

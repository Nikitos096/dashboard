<?php

declare(strict_types=1);

namespace App\Container\Model\User\Service;

use App\Model\User\Service\ResetTokenSender;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime;

class ResetTokenSenderFactory
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function create(string $from): ResetTokenSender
    {
        return new ResetTokenSender($this->mailer, new Mime\Email(), new Address($from));
    }
}
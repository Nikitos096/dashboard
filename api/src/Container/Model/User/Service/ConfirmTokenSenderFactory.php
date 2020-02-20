<?php

declare(strict_types=1);

namespace App\Container\Model\User\Service;

use App\Model\User\Service\ConfirmTokenSender;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime;

class ConfirmTokenSenderFactory
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function create(string $from): ConfirmTokenSender
    {
        return new ConfirmTokenSender($this->mailer, new Mime\Email(), new Address($from));
    }
}
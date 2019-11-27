<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\StaffingRequest;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

final class StaffingNotificationHandler
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function __invoke(StaffingRequest $staffingRequest): void
    {
        $email = (new Email())
            ->from('fabien@symfony.com')
            ->to('foo@example.com')
            ->cc('bar@example.com')
            ->bcc('baz@example.com')
            ->replyTo('fabien@symfony.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Important Notification')
            ->text('Lorem ipsum...')
            ->html('<h1>Lorem ipsum</h1> <p>...</p>');

        $this->mailer->send($email);
    }
}

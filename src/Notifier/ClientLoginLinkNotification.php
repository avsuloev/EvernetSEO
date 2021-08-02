<?php

namespace App\Notifier;

use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkDetails;
use Symfony\Component\Security\Http\LoginLink\LoginLinkNotification;

class ClientLoginLinkNotification extends LoginLinkNotification
{
    public function __construct(
        private LoginLinkDetails $loginLinkDetails,
        private string $clientName,
        string $subject,
        array $channels = [],
    ) {
        parent::__construct($loginLinkDetails, $subject, $channels);
    }

    public function asEmailMessage(
        EmailRecipientInterface $recipient,
        string $transport = null,
    ): EmailMessage {
        $email = NotificationEmail::asPublicEmail()
            ->from('admin@example.com')
            ->to($recipient->getEmail())
            ->subject($this->getSubject())
            ->htmlTemplate('email/_client_login_link_email.html.twig')
            ->context([
                'expiration_date' => $this->getLeftTime(),
                'username' => $this->clientName,
            ])
            ->action('Sign in', $this->loginLinkDetails->getUrl())
        ;

        return new EmailMessage($email);
    }

    /**
     * Get the lifetime of the link.
     */
    public function getLeftTime(): string
    {
        $duration = $this->loginLinkDetails->getExpiresAt()->getTimestamp() - time();
        $durationString = floor($duration / 60).' minute'.($duration > 60 ? 's' : '');
        if (($hours = $duration / 3600) >= 1) {
            $durationString = floor($hours).' hour'.($hours >= 2 ? 's' : '');
        }

        return $durationString;
    }
}

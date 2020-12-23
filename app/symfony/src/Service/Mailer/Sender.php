<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class Sender implements SenderInterface
{
    private MailerInterface $mailer;
     private string $companyEmail;
     private Environment $twig;
    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->companyEmail = $_ENV['AGENCY_EMAIL'];
        $this->twig = $twig;
    }

    public function deliver(
        string $to,
        string $subject,
        string $content,
        ?array $bindings ,
        ?array $attachments
    ): void {
        $email = new Email();

        $email->from($this->companyEmail);
        $email->to($to);
        $email->subject($subject);
        $email->html(SenderHelper::bind($content, $bindings));
        $this->mailer->send($email);
    }


    public function doTemplate($template, ?array $options = [])
    {
        return $this->twig->render($template, $options);
    }
}

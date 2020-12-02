<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Order;
use App\Entity\Token;
use App\Event\UserEvent;
use App\EventSubscriber\Traits\LetterTrait;
use App\Manager\UserManager;
use App\Service\Mailer\Sender;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserSubscriber implements EventSubscriberInterface
{
    private Sender $sender;

    private UserManager $userManager;

    private UrlGeneratorInterface $urlGenerator;

    private EntityManagerInterface $em;

    private SessionInterface $session;
    private Environment $twig;

    use LetterTrait;

    public function __construct(
        Sender $sender,
        UserManager $userManager,
        RouterInterface $router,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        Environment $twig
    )
    {
        $this->sender = $sender;
        $this->userManager = $userManager;
        $this->urlGenerator = $urlGenerator;
        $this->em = $entityManager;
        $this->session = $session;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserEvent::REGISTERED => 'onRegistered',
            UserEvent::REGISTERED_CONFIRMED => 'onRegisteredConfirmed',
            UserEvent::LOGGED => 'onLogged',
            UserEvent::RESETED => 'onReseted',
        ];
    }

    /**
     * @param UserEvent $event
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onRegistered(UserEvent $event): void
    {
        $token = $this->em->getRepository(Token::class)->findOneBy([
            'user' => $event->getUser(),
            'type' => Token::TYPE_CONFIRM,
        ]);

        $url = $this->urlGenerator->generate('registration_confirm', ['value' => $token->getValue()], UrlGeneratorInterface::ABSOLUTE_URL);
        $template = $this->twig->render('security/comfirm_mail.html.twig', ['url' => $url]);
        $this->sender->deliver(
            $event->getUser()->getEmail(),
            'mail confirmation',
            $template,
            [],
            []
        );
    }

    /**
     * @param UserEvent $event
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onRegisteredConfirmed(UserEvent $event): void
    {
        $event->getUser()->setEnabled(true);

        $this->em->flush();
        $template = $this->twig->render('security/enabled_mail.html.twig');

        $this->sender->deliver(
            $event->getUser()->getEmail(),
            'enabled email',
            $template,
            [],
            []
        );
    }

    /**
     * @param UserEvent $event
     */
    public function onLogged(UserEvent $event): void
    {
        $user = $event->getUser();
        $client = $user->getClient();

        $order = $this->em->getRepository(Order::class)->findOneBy(['client' => $client, 'status' => Order::STATUS_PENDING], ['id' => 'DESC']);

        if ($order) {
            $this->session->set('latest_pending_order', $order->getId());
        }
    }

    /**
     * @param UserEvent $event
     */
    public function onReseted(UserEvent $event): void
    {
        $user = $event->getUser();

        $letter = $this->getLetterInfo(UserEvent::RESETED);

        $this->sender->deliver(
            $user->getEmail(),
            $letter->getSubject(),
            $letter->getContent(),
            ['url' => $this->urlGenerator->generate('user_reset', ['token' => $this->userManager->getTokenByUser($user)])],
            []
        );
    }

}

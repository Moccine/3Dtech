<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Subscriber;
use App\Form\SubscriberType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SubscriptionExtension extends AbstractExtension
{
    /**
     * @var FormFactoryInterface
     */
    protected $form;

    public function __construct(FormFactoryInterface $form)
    {
        $this->form = $form;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('subscription_get_form_view', [$this, 'getFormView']),
        ];
    }

    public function getFormView(): FormView
    {
        $form = $this->form->create(SubscriberType::class, new Subscriber());

        return $form->createView();
    }
}

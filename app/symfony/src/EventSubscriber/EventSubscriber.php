<?php


namespace App\EventSubscriber;

use App\Entity\Quotation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['setQuotationAmount'],
        ];
    }

    public function setQuotationAmount(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (($entity instanceof Quotation)) {
            dd($entity);
            /** @var Quotation $entity */
            $products = $entity->getProducts();
            $price = 0;
            foreach ($products as $product) {
                $price += $product->getPrice();
            }
            $amount = $price * $entity->getQuantity();
            $entity->setAmount($amount);
        }


        }
}

<?php


namespace App\EventSubscriber;

use App\Entity\Client;
use App\Entity\Quotation;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityBuiltEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [

            BeforeEntityPersistedEvent::class => ['setQuotationAmount'],
            BeforeEntityUpdatedEvent::class => ['updateQuotationAmount'],
            /* AfterEntityBuiltEvent::class => [],
             AfterEntityDeletedEvent::class => [],
             AfterEntityPersistedEvent::class => [],
             BeforeEntityDeletedEvent::class => [],
             BeforeEntityUpdatedEvent::class => [],
             BeforeCrudActionEvent::class => [],
             AfterCrudActionEvent::class => [],*/

        ];
    }

    public function setQuotationAmount(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if (($entity instanceof Quotation)) {
            $this->calculateQuotationAmount($entity);
        }
    }

    public function updateQuotationAmount(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if (($entity instanceof Quotation)) {
            $this->calculateQuotationAmount($entity);
        }
    }

    public function calculateQuotationAmount(Quotation $quotation)
    {
        $products = $quotation->getProducts();
        $price = 0;
        foreach ($products as $product) {
            $price += $product->getPrice();
        }
        $totalHt = $price * $quotation->getQuantity();
        $quotation->setAmount($totalHt*(1+0.2))->setTotalHt($totalHt);
        $client = $quotation->getClient();
        if ($quotation->getClient() instanceof Client) {
            $address = sprintf("%s %s %s %s",
                $client->getAddress(),
                $client->getPostalCode(),
                $client->getCity(),
                $client->getCountry()
            );
            $quotation->setAddress($address);
        }
    }

}

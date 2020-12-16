<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Machine;
use App\Entity\Order;
use App\Entity\Voucher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoucherType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voucher::class,
            'csrf_protection' => false,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('machine', EntityType::class, [
               'class' => Machine::class,
            ])
            ->add('order', EntityType::class, [
                'class' => Order::class,
            ])
        ;
    }
}

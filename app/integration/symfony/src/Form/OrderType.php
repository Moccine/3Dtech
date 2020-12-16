<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'step' => null,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        switch ($options['step']) {
            case 1:
                $builder
                    ->add('purchases', CollectionType::class, [
                        'label' => false,
                        'entry_type' => PurchaseType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    ])
                    ->add('submit', SubmitType::class, [
                        'label' => 'app.form.registration.submit',
                    ])
                ;
                break;
            case 2:
                $builder
                    ->add('options', CollectionType::class, [
                        'label' => false,
                        'entry_type' => OptionType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    ])
                    ->add('submit', SubmitType::class, [
                        'label' => 'app.form.registration.submit',
                    ])
                ;
                break;
        }
    }
}

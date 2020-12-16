<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('delivery', ChoiceType::class, [
                'label' => 'app.form.cart.delivery',
                'choices' => Purchase::$types,
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('startDate', DateType::class, [
                'label' => 'app.form.cart.startDate',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('endDate', DateType::class, [
                'label' => 'app.form.cart.endDate',
                'widget' => 'single_text',
                'required' => true,
            ])
        ;
    }
}

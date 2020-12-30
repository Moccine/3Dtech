<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\QuotationLine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'placeholder' => 'Choisir un produit',
                'attr' => [
                    'placeholder' =>'Quantité',
                    'class' => 'col-lg-6'
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'label' => false,
                'data' => 1,
                'attr' => [
                    'class' => 'col-lg-4'
                ]
            ])
             ->add('unitPrice', MoneyType::class, [
                 'label' => false,
                 'attr' => [
                     'placeholder' =>'Prix unitaire',
                     'class' => 'col-lg-6',
                 ]
             ])
              ->add('discount', MoneyType::class, [
                  'label' => false,
                  'attr' => [
                      'placeholder' =>'Remisee',
                      'class' => 'col-lg-6'
                  ]
              ])
              ->add('totalHt', MoneyType::class, [
                  'label' => false,
                  'attr' => [
                      'placeholder' =>'HT',
                      'class' => 'col-lg-6'
                  ]
              ])
              ->add('amount', MoneyType::class, [
                  'label' => false,
                  'attr' => [
                      'placeholder' =>'TTC',
                      'class' => 'col-lg-6'
                  ]
              ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuotationLine::class
        ]);
    }
}

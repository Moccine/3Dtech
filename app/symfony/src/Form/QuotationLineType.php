<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\QuotationLine;
use App\Entity\Vat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
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
                'label' => false,
                'attr' => [
                    'class' => 'add-product'
                ]
            ])
            ->add('vat', EntityType::class, [
                'class' => Vat::class,
                'placeholder' => 'Choisir un tva',
                'label' => false,
                'attr' => [
                    'class' => ' vat'
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'label' => false,
                'data' => 1,
                'attr' => [
                    'class' => ' quantity'
                ]
            ])
             ->add('unitPrice', MoneyType::class, [
                 'label' => false,
                 'attr' => [
                     'placeholder' =>'Prix unitaire',
                     'class' => ' unitPrice',
                 ]
             ])
              ->add('discount', PercentType::class, [
                  'label' => false,
                  'attr' => [
                      'placeholder' =>'Remise en %',
                      'class' => ' discount'
                  ]
              ])
              ->add('totalHt', MoneyType::class, [
                  'label' => false,
                  'attr' => [
                      'placeholder' =>'HT',
                      'class' => ' ht'
                  ]
              ])
              ->add('amount', MoneyType::class, [
                  'label' => false,
                  'attr' => [
                      'placeholder' =>'TTC',
                      'class' => ' ttc'
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

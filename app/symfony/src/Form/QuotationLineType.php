<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\QuotationLine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           //->add('unitPrice')
            ->add('discount')
           // ->add('totalHt')
           // ->add('amount')
            ->add('deposit')
           ->add('quantity')
            ->add('product', EntityType::class, [
                'class' => Product::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}

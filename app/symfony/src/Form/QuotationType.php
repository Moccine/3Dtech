<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Quotation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       /* $builder
            ->add('name')
            ->add('description')
            ->add('quotationDate')
            ->add('reference')
            ->add('deadline')
            ->add('payment')
            ->add('amount')
            ->add('totalHt')
            ->add('quantity')
            ->add('designation')
            ->add('status')
            ->add('deposit')
            ->add('billingAddress')
        ;*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quotation::class,
        ]);
    }
}

<?php
declare(strict_types=1);

namespace App\Form;

use App\Constant\Payment;
use App\Entity\Deadlines;
use App\Entity\Quotation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('quotationDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('reference')
            ->add('deadline', EntityType::class, [
                'class' => Deadlines::class,
                'label' => false,
            ])
            ->add('payment', ChoiceType::class,[
                'choices' => array_flip(Payment::PAYMENT),
                    'attr' => ['class' => 'wide'],

            ])
            ->add('amount', MoneyType::class, )
            ->add('totalHt', MoneyType::class)
            ->add('quantity', IntegerType::class)
            ->add('designation')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'en cours' => 1,
                    'Archiver' => 2,
                    'Valierd' => 3,
                ]
            ])
            ->add('deposit')
            ->add('description', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quotation::class,
        ]);
    }
}

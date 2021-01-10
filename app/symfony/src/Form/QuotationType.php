<?php
declare(strict_types=1);

namespace App\Form;

use App\Constant\Payment;
use App\Entity\Deadlines;
use App\Entity\Quotation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'label' => 'status',
                'attr' => ['class' => 'wide'],
                'data' => 3,
                'choices' => [
                    'en cours' => 1,
                    'Archiver' => 2,
                    'Valider' => 3,
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'data' => 'Nom',
                'attr' => [
                    'class' => 'removeMargin',
                    'placeholder' => 'Nom',
                ]
            ])
            ->add('quotationDate', DateType::class, [
                'label' => 'Prenom',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Date de creation'
                ],
                'format' => 'mm/dd/yyyy'
            ])
            ->add('reference', TextType::class, [
                'label' => 'Reférence',
                'data' => 'reference',
                'attr' => [
                    'class' => 'removeMargin',
                    'placeholder' => 'Reference',
                ]
            ])
            ->add('designation', TextType::class, [
                'label' => 'Désignetion',
                'data' => 'reference',

                'attr' => [
                    'class' => 'removeMargin',
                    'placeholder' => 'Designation',
                ]
            ])
            ->add('deadline', EntityType::class, [
                'class' => Deadlines::class,
                'label' => 'Date de paiement',
                'attr' => ['class' => 'wide'],

            ])
            ->add('payment', ChoiceType::class, [
                'label' => '',
                'choices' => array_flip(Payment::PAYMENT),
                'attr' => [
                    'class' => 'wide client-type'
                ],
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'TTC',
                //'data' => 67,
                'attr' => [
                    'class' => 'money-type',

                ],
            ])
            ->add('totalHt', MoneyType::class, [
                'label' => 'HT',
                'attr' => [
                    'class' => 'money-type',
                ],
            ])
           /* ->add('deposit', MoneyType::class, [
                'label' => 'Acompte',
                'data' => 0,
                'attr' => [
                    'placeholder' => 'Acompte',
                    'class' => 'money-type'
                ]
            ])
           */
            ->add('description', TextareaType::class, [
                'data' => 'Prélevemnt',
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Description',
                    'required' => false
                ]
            ])
            ->add('quotationLine', CollectionType::class, [
                'entry_type' => QuotationLineType::class,
                'label' => false,
                'required' => false,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'error_bubbling' => true,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quotation::class,
            'cascade_validation' => true,
        ]);
    }
}

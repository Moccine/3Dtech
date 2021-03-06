<?php

namespace App\Form;

use App\Entity\AskOfQuote;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskOfQuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', null, [
            'placeholder' => '- Choisissez votre projet IT ? -',
            'label' => false,
            'attr' => [
                'class' => 'input-box',

            ],
            'class' => Category::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'choice_label' => 'name',
        ])
            ->add('deadline', null, [
                'placeholder' => '- Pour quel délai ? -*',
                'label' => false,
            ])
            ->add('materialNumber', ChoiceType::class, [
                'placeholder' => '- Nombre d\'ordinateur(s) -',
                'label' => false,
                'choices' => (range(1, 10)),

            ])
            ->add(
                'serverNumber',
                ChoiceType::class,
                [
                    'placeholder' => '- Nombre de serveur(s) -',
                    'label' => false,
                    'choices' => range(1, 10),
                ]
            )
            ->add('name', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => '- Votre nom et prénom* -'
                ]
            ])
            ->add(
                'company',
                null,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Votre entreprise*'
                    ]
                ]
            )
            ->add('email', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse email*'
                ]
            ])
            ->add('phone', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre numéro*'
                ]
            ])
            ->add('description', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre nom et prénom*'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'app.form.registration.submit',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AskOfQuote::class,
        ]);
    }
}

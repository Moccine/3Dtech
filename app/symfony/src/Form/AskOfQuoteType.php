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
        $descrption = "Lorem Ipsum is simply dummy text of the printing and typesetting i
        ndustry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
        when an unknown printer took a galley of type and scrambled it to make a type specimen book.
         It has survived not only five centuries, but also the leap into electronic typesetting,
          remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
";
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
            ->add('serverNumber', ChoiceType::class, [
                    'placeholder' => '- Nombre de serveur(s) -',
                    'label' => false,
                    'choices' => range(1, 10),
                ]
            )
            ->add('name', null, [
                'label' => false,
                'data' => 'Nom',
                'attr' => [
                    'placeholder' => '- Votre nom et prénom* -'
                ]
            ])
            ->add('company', null, [
                    'data' => 'Company',

                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Votre entreprise*'
                    ]
                ]
            )
            ->add('email', null, [
                'label' => false,
                'data' => 'email@gmail.co',

                'attr' => [
                    'placeholder' => 'Adresse email*'
                ]
            ])
            ->add('phone', null, [
                'data' => '0700000000',
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre numéro*'
                ]
            ])
            ->add('description', null, [
                'label' => false,
                'data' => $descrption,
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

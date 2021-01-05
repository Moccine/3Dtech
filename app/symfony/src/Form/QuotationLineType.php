<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\QuotationLine;
use App\Entity\Vat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationLineType extends AbstractType
{
    private EntityManagerInterface $em;

    /**
     * QuotationLineType constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Vat $defaultVat */
        $defaultVat = $this->em->getRepository(Vat::class)->findOneBy([
            'name' => '0%',
        ]);
        dump($defaultVat);
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'placeholder' => 'Choisir un produit',
                'label' => 'Produit',
                'attr' => [
                    'class' => 'add-product'
                ]
            ])
            ->add('vat', ChoiceType::class, [
                'label' => 'Tva',
                 'choices' => $this->em->getRepository(Vat::class)->findAll(),
                  'choice_label' => 'name',
                'choice_value' => 'id',
                'attr' => [
                    'class' => ' vat'
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
                'data' => 1,
                'attr' => [
                    'class' => ' quantity'
                ]
            ])
             ->add('unitPrice', MoneyType::class, [
                 'label' => 'Prix unitaire',
                 'attr' => [
                     'placeholder' =>'Prix unitaire',
                     'class' => ' unitPrice',
                 ]
             ])
              ->add('discount', PercentType::class, [
                  'label' => 'Acompte',
                  'attr' => [
                      'placeholder' =>'Remise en %',
                      'class' => ' discount'
                  ]
              ])
              ->add('totalHt', MoneyType::class, [
                  'label' => 'HT',
                  'attr' => [
                      'placeholder' =>'HT',
                      'class' => ' ht'
                  ]
              ])
              ->add('amount', MoneyType::class, [
                  'label' => 'TTC',
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

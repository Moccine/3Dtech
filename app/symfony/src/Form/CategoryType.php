<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', EntityType::class, [
                'required' => true,
                'label' => 'app.category.code',
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $repository) {
                    return $repository->createQueryBuilder('c');
                },
                'choice_value' => 'id',
                'choice_label' => 'code',
                'multiple' => true,
            ])
            ->add('Rechercher', SubmitType::class)
        ;
    }
}

<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Incident;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Incident::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'app.form.incident.lastName',
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
                'label' => 'app.form.incident.firstName',
            ])
            ->add('description', TextType::class, [
                'required' => true,
                'label' => 'app.form.incident.description',
            ])
            ->add('submit', SubmitType::class)
        ;
    }
}

<?php

namespace App\Form;

use App\Entity\Qualification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QualificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('school')
            ->add('date')
            ->add('description')
            ->add('logo')
            ->add('link')
            ->add('position')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Qualification::class,
        ]);
    }
}

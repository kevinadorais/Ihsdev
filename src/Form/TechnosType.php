<?php

namespace App\Form;

use App\Entity\Technos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            // On ajoute le champ logo non mapped, à traîter dans le controller
            ->add('logo', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false,])
            ->add('alt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Technos::class,
        ]);
    }
}

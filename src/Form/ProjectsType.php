<?php

namespace App\Form;

use App\Entity\DevSkills;
use App\Entity\Projects;
use App\Entity\Technos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('website')
            ->add('technos', EntityType::class, array(
                'class' => Technos::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            )) 
            ->add('devSkills', EntityType::class, array(
                'class' => DevSkills::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('projectImgs', FileType::class, array(
                'mapped' => false,
                'label' => 'Images',
                'multiple' => true,
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}

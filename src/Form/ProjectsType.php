<?php

namespace App\Form;

use App\Entity\Projects;
use App\Entity\Technos;
use App\Entity\DevSkills;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('website')

            // On recupère les infos existante des Technos pour créer un choix multiple et existant.
            ->add('technos', EntityType::class, array(
                'class' => Technos::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,)) 
            
            // On recupère les infos existante des DevSkills pour créer un choix multiple et existant.
            ->add('devSkills', EntityType::class, array(
                'class' => DevSkills::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,)) 

            // On ajoute le champ images non mapped, à traîter dans le controller
            ->add('images', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}

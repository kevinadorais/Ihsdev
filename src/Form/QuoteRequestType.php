<?php

namespace App\Form;

use App\Entity\QuoteRequest;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom',
            )) 
            ->add('phone', TextType::class, array(
                'label' => 'Téléphone',
            ))
            ->add('mail', TextType::class, array(
                'label' => 'E-mail',
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Message',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuoteRequest::class,
        ]);
    }
}

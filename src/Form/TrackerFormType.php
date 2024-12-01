<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'attr' => ['placeholder' => 'Entrez votre pseudo','class' => 'form-control'],       
            ])
            ->add('platform', ChoiceType::class, [
                'label' => 'Plateforme',
                'choices' => [
                    'PC' => 'PC',
                    'PlayStation' => 'PS4',
                    'Xbox' => 'X1',
                ],
                'expanded' => true, // Affichage sous forme de boutons radio
                'multiple' => false, // Assurez-vous que ce n'est pas multiple
                'attr' => ['class' => 'd-flex gap-3'], // Ajoutez une classe pour espacer les boutons
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}

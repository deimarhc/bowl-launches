<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('department', ChoiceType::class, [
                'choices' => [
                    'Cundinamarca' => 'cundinamarca',
                ],
            ])
            ->add('city', ChoiceType::class, [
                'choices' => [
                    'Madrid' => 'madrid',
                    'Mosquera' => 'mosquera',
                    'Funza' => 'funza',
                ],
            ])
            ->add('neighborhood')
            ->add('address')
            ->add('indications')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

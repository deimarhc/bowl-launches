<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Lunch;
use App\Entity\OrderItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('lunch', EntityType::class, [
                'class' => Lunch::class,
                'choice_label' => 'name',
                'choice_attr' => function(Lunch $lunch) {
                    return ['data-is-custom' => $lunch->getIsCustom()];
                }
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'multiple' => true,
                'row_attr' => [
                    'class' => 'ingredients-container'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
        ]);
    }
}


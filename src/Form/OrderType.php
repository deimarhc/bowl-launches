<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('shipping_price')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.created', 'DESC');
                },
            ])
            ->add('address', EntityType::class, [
                'class' => Address::class,
                'choice_label' => function (Address $address) {
                    return $address->getDisplayName();
                },
            ])
            ->add('items', CollectionType::class, [
                'entry_type' => OrderItemType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'attr' => [
                    'class' => 'multiple-list-group multiple-order-item',
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $form->add('status', ChoiceType::class, [
                'expanded' => true,
                'choices' => [
                    'Created' => Order::CREATED,
                    'Processed' => Order::PROCESSED,
                    'Delivered' => Order::DELIVERED,
                    'Finished' => Order::FINISHED,
                ],
                'data' => $event->getData()->getStatus() ?: Order::FINISHED,
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}

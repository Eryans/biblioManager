<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name',TextType::class,["label" => "Firstname"])
            ->add('last_name',TextType::class,["label" => "Lastname"])
            ->add('birth_date',DateType::class,['widget' => 'single_text','label' => 'Birthdate'])
            ->add('adress',TextType::class)
            ->add('city',TextType::class)
            ->add('mail',TextType::class)
            ->add('phone',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class, DateType::class
        ]);
    }
}

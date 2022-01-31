<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
            ->add('first_name')
            ->add('last_name')
            ->add('birth_date', DateType::class, ['widget' => 'single_text'])
            ->add('adress')
            ->add('city')
            ->add('mail')
            ->add('phone')
=======
            ->add('first_name',TextType::class)
            ->add('last_name',TextType::class)
            ->add('birth_date',DateType::class,['widget' => 'single_text'])
            ->add('adress',TextType::class)
            ->add('city',TextType::class)
            ->add('mail',TextType::class)
            ->add('phone',TextType::class)
>>>>>>> 485b58c76e3e89a0c4d78bee64eda326928a32da
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class, DateType::class
        ]);
    }
}

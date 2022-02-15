<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                "label" => "Firstname",
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 60
                    ]),
                ]
            ])
            ->add('last_name', TextType::class, [
                "label" => "Lastname",
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 60
                    ]),
                ]
            ])
            ->add('birth_date', DateType::class, [
                'widget' => 'single_text', 'label' => 'Birthdate',
                'label_attr' => ['style' => 'height:100%;width:100%;']
            ])
            ->add('adress', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 95
                    ]),
                ]
            ])
            ->add('city', TextType::class, ['constraints' => [
                new Length([
                    'min' => 1,
                    'max' => 35
                ]),
            ]])
            ->add('mail', TextType::class, ['constraints' => [
                new Length([
                    'min' => 1,
                    'max' => 62
                ]),
            ]])
            ->add('phone', TextType::class, ['constraints' => [
                new Length([
                    'min' => 1,
                    'max' => 15
                ]),
                new Regex(['pattern' => '/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/'])
            ]])
            ->add("submit", SubmitType::class, ["attr" => ["class" => "btn btn-primary fs-1"]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class, DateType::class
        ]);
    }
}

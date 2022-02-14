<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,["label" => "Title",
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 2,
                    'max' => 100
                ]),
            ]])
            ->add('author',TextType::class,['constraints' => [
                new Length([
                    'min' => 1,
                    'max' => 100
                ]),
            ]])
            ->add('summary',TextAreaType::class,[
            'constraints' => [
                new Length([
                    'min' => 2,
                    'max' => 400
                ])]])
            ->add('release_date',DateType::class, ['widget' => 'single_text',"label" => "release_date"])
            ->add('category',TextType::class,['constraints' => [
                new Length([
                    'min' => 2,
                    'max' => 50
                ])]])
            ->add('for_child',CheckboxType::class,['required' => false, 'label' => 'forChild'])
            ->add('quantity',NumberType::class,[])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}

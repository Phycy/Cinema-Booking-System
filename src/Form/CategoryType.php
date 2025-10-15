<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Category name cannot be empty.',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Category name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Category name cannot exceed {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('discription', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Description cannot be empty.',
                    ]),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'Description must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Description cannot exceed {{ limit }} characters.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}

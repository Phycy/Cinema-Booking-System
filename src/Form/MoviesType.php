<?php

namespace App\Form;

use App\Entity\Movies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class MoviesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('title', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Title cannot be empty.']),
                new Assert\Length([
                    'min' => 2,
                    'max' => 100,
                    'minMessage' => 'The title must be at least {{ limit }} characters long.',
                    'maxMessage' => 'The title cannot exceed {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('genre', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Genre is required.']),
            ],
        ])
        ->add('description', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Description cannot be empty.']),
                new Assert\Length([
                    'min' => 10,
                    'minMessage' => 'Description must be at least {{ limit }} characters long.',
                ]),
            ],
        ])
        ->add('time', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Time is required.']),
            ],
        ])
        ->add('date', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Date is required.']),
                new Assert\Date(['message' => 'Please enter a valid date.']),
            ],
        ])

        ->add('duration', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Duration is required.']),
                new Assert\Regex([
                'pattern' => '/^\d{1,2}:\d{2}$/',
                'message' => 'Please enter duration in HH:MM format (e.g. 1:20 or 02:05).',
                ]),
            ],
            
        ]);
}

}




/*

public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('title', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Title cannot be empty.']),
                new Assert\Length([
                    'min' => 2,
                    'max' => 100,
                    'minMessage' => 'The title must be at least {{ limit }} characters long.',
                    'maxMessage' => 'The title cannot exceed {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('genre', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Genre is required.']),
            ],
        ])
        ->add('description', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Description cannot be empty.']),
                new Assert\Length([
                    'min' => 10,
                    'minMessage' => 'Description must be at least {{ limit }} characters long.',
                ]),
            ],
        ])
        ->add('time', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Time is required.']),
            ],
        ])
        ->add('date', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Date is required.']),
                new Assert\Date(['message' => 'Please enter a valid date.']),
            ],
        ])
        ->add('duration', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Duration is required.']),
                new Assert\Positive(['message' => 'Duration must be a positive number.']),
            ],
        ]);
}







public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('genre')
            ->add('description')
            ->add('time')
            ->add('date')
            ->add('duration')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movies::class,
        ]);
    }
*/
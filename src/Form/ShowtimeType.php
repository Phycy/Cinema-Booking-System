<?php

namespace App\Form;

use App\Entity\Movies;
use App\Entity\Showtime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowtimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hallNumber')
            ->add('dateTime', null, [
                'widget' => 'single_text',
            ])
            ->add('totalSeats')
            ->add('availableSeats')
            ->add('ticketPrice')
            ->add('movie', EntityType::class, [
                'class' => Movies::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Showtime::class,
        ]);
    }
}

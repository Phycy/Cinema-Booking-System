<?php

namespace App\Form;

use App\Entity\BookingSit;
use App\Entity\Showtime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingSitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seatNumber')
            ->add('status')
            ->add('userName')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('showtime', EntityType::class, [
                'class' => Showtime::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookingSit::class,
        ]);
    }
}

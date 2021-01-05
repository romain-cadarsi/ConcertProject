<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Hall;
use App\Entity\Show;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tournee', TextType::class,['label' => 'Nom de la tournée'])
            ->add('date',DateType::class,[
                'widget' => 'choice',
                'format' => "dd / MM / yyyy"
            ])
            ->add('hall', EntityType::class, [
                'class' => Hall::class,
                'choice_label' => 'name'
            ])
            ->add('band', EntityType::class,[
                'class' => Band::class,
                'choice_label' => "name",
                'multiple' => true
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Show::class,
        ]);
    }
}

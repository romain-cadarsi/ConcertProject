<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,['label' => 'Nom du groupe'])
            ->add('style',TextType::class,[
               'label' => "Style de musique"
            ])
            ->add('yearOfCreation',DateType::class,[
                'widget' => 'choice',
                'format' => "dd / MM / yyyy"
            ])
            ->add('lastAlbumName', TextType::class, [
                'label' => "Dernier album"
            ])
            ->add('member', EntityType::class,[
                'class' => Member::class,
                'choice_label' => "name",
                'multiple' => true
            ])
            ->add('picture', FileType::class,[
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '40000k',
                        'mimeTypes' => [
                            'application/jpg',
                            'application/jpeg',
                            'application/png',
                            'application/webp',
                        ],
                        'mimeTypesMessage' => "Ce n'est pas une image valide",
                    ])
                ],
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}

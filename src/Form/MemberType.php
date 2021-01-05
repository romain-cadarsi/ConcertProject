<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,['label' => 'Nom du membre'])
            ->add('firstName', TextType::class,['label' => 'Prénom du membre'])
            ->add('job',TextType::class,[
                'label' => "Role"
            ])
            ->add('birthDate',DateType::class,[
                'widget' => 'choice',
                'format' => "dd / MM / yyyy",
                'label' => "date de naissance"
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
            'data_class' => Member::class,
        ]);
    }
}

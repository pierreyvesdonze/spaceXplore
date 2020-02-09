<?php

namespace App\Form\Type;

use App\Entity\Galaxy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class GalaxyType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {

        $builder->add(
            'name',
            TextType::class,
            [
                "label" => "Nom de la galaxie"
            ]
        );

        $builder->add(
            'age',
            IntegerType::class,
            [
                "label" => "Âge de la galaxie (en milliards d'années)"
            ]
        );

        $builder->add(
            'size',
            TextType::class,
            [
                "label" => "Taille de la galaxie"
            ]
        );

        $builder->add(
            'constellation',
            TextType::class,
            [
                "label" => "Constellation parente"
            ]
        );

        $builder->add(
            'description',
            TextareaType::class,
            [
                "label" => "Ajouter une description"
            ]
        );

        $builder->add('brochure', FileType::class, [
          
            'label'         => 'Ajouter une image (JPG)',
            'mapped'        => false,
            'required'      => true,
            'constraints'   => [
                new File()
            ],
        ]);
        
        $builder->add(
            'save',
            SubmitType::class, 
            [
                "label" => "Ajouter"
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Galaxy::class,
        ]);
    }
}

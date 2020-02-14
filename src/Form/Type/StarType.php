<?php

namespace App\Form\Type;

use App\Entity\Galaxy;
use App\Entity\Star;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class StarType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {

        $builder->add(
            'galaxy',
            EntityType::class,
            [
                "class" => Galaxy::class,
                "choice_label" => "name"
            ]
        );

        $builder->add(
            'name',
            TextType::class,
            [
                "label" => "Nom de l'objet"
            ]
        );

        $builder->add(
            'age',
            TextType::class,
            [
                "label" => "Âge de l'objet"
            ]
        );

        $builder->add(
            'type',
            TextType::class,
            [
                "label" => "Type d'objet"
            ]
        );

        $builder->add(
            'masse',
            TextType::class,
            [
                "label" => "Masse de l'objet"
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
            'data_class' => Star::class,
        ]);
    }
}

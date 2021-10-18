<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Figure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Le titre',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Veuillez saisir le titre'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'La description',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Veuillez saisir le contenu'
                ]
            ])
            ->add('files', FileType::class, [
                'label' => 'Les images',
                'required' => false,
                'mapped' => false,
                'multiple' => true
            ])
            ->add('category', EntityType::class, [
                'label' => 'La catégorie',
                'required' => true,
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Enregister"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Figure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('slug', TextType::class, [
                'label' => 'Le slug',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Veuillez saisir le slug'
                ]
            ])
            ->add('content', TextType::class, [
                'label' => 'La description',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Veuillez saisir le contenu'
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'La catégorie',
                'required' => true,
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
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

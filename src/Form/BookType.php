<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom du livre'
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Catégories:',
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'expanded' => false,
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('author', EntityType::class, [
                'label' => 'Auteur:',
                'required' => false,
                'class' => Author::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'expanded' => false,
                'multiple' => false,
            ]);
    }
}

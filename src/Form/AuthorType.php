<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prénom de l\'auteur'
                ]
            ]);
    }
}

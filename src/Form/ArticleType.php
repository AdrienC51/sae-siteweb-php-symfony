<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\KeyWord;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'empty_data' => '',
            ])
            ->add('price', null, [
                'empty_data' => '',
            ])
            ->add('description', null, [
                'empty_data' => '',
            ])
            ->add('picture', null, [
                'empty_data' => '',
            ])
            ->add('keyWords', EntityType::class, [
                'class' => KeyWord::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\KeyWord;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('picture', FileType::class, [
                'label' => 'Upload Image (JPEG, PNG)',
                'mapped' => false, // L'image ne sera pas directement liée à une propriété de l'entité
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Please upload a valid JPEG or PNG image.',
                    ]),
                ],
                'required' => false,
            ])
            ->add('keyWords', EntityType::class, [
                'class' => KeyWord::class,
                'choice_label' => 'word',
                'multiple' => true,  // Permet la sélection multiple
                'expanded' => true,  // Affiche les mots-clés sous forme de checkboxes
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('k')
                        ->orderBy('k.word', 'ASC');
                },
                'attr' => [
                    'class' => 'form-check',
                ],
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'attr' => [
                    'class' => 'form-check',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

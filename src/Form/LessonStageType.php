<?php

namespace App\Form;

use App\Entity\LessonStage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LessonStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lesson',TextType::class, [
                'disabled'=>true,
                'label' => 'Урок',
            ])
            ->add('name',TextType::class, [
                 'label' => 'Название',
            ])
            ->add('guidance',TextareaType::class, [
                'label' => 'Правила рисования',
                'required'=>false
            ])
            ->add('exampleImageStage', FileType::class, [
                'label' => 'Пример выполнения этапа (pdf/jpeg)',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/PNG',

                        ],
                        'mimeTypesMessage' => 'Пожалуйста выберете файл расширения png/jpeg',
                    ])
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LessonStage::class,
        ]);
    }
}

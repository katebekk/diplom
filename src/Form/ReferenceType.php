<?php

namespace App\Form;

use App\Entity\Reference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rule',TextType::class, [
                'label' => 'Правило рисования',
                'required'=>false
            ])
            ->add('drawingImage', FileType::class, [
                'label' => 'Изображение эталонного рисунка (pdf/jpeg)',
                'mapped' => false,
                'required'=>false,
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
            ->add('lessonStage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reference::class,
        ]);
    }
}

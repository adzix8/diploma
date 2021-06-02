<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class CSVFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Plik CSV',
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'text/csv',
                        ],
                        'mimeTypesMessage' => 'Proszę wgrać plik CSV',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Wyślij',
                'attr' => ['class' => 'btn btn--sm'],
            ]);
    }
}

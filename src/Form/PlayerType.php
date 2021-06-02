<?php

namespace App\Form;

use App\Entity\Position;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię i nazwisko',
            ])
            ->add('age', NumberType::class, [
                'label' => 'Wiek',
            ])
            ->add('height', NumberType::class, [
                'label' => 'Wzrost',
            ])
            ->add('topSpeed', NumberType::class, [
                'label' => 'Szybkość',
                'attr' => [
                    'oninput' => 'setFloatValue(this)',
                    'type' => 'number',
                ],
            ])
//            ->add('positions', EntityType::class, [
//                'class' => Position::class,
//                'choice_label' => 'name',
//                'multiple' => true,
//                'label' => 'Pozycje',
//                'row_attr' => ['class' => 'flex vertical-center none'],
//            ])
            ->add('goals', NumberType::class, [
                'label' => 'Gole',
            ])
            ->add('assists', NumberType::class, [
                'label' => 'Asysty',
            ])
            ->add('dualsWon', NumberType::class, [
                'label' => 'Pojedynki wygrane',
            ])
            ->add('clearances', NumberType::class, [
                'label' => 'Przejęcia piłki',
                'attr' => [
                    'oninput' => 'setFloatValue(this)',
                    'type' => 'number',
                ],
            ])
            ->add('errors', NumberType::class, [
                'label' => 'Błędy',
            ])
            ->add('touches', NumberType::class, [
                'label' => 'Dotknięcia piłki',
                'attr' => [
                    'oninput' => 'setFloatValue(this)',
                    'type' => 'number',
                ],
            ])
            ->add('passesCompleted', NumberType::class, [
                'label' => 'Dokładne podania',
            ])
            ->add('chances', NumberType::class, [
                'label' => 'Wykreowane szanse',
            ])
            ->add('dribbles', NumberType::class, [
                'label' => 'Dryblingi',
                'attr' => [
                    'oninput' => 'setFloatValue(this)',
                    'type' => 'number',
                ],
            ])
            ->add('crosses', NumberType::class, [
                'label' => 'Dośrodkowania',
                'attr' => [
                    'oninput' => 'setFloatValue(this)',
                    'type' => 'number',
                ],
            ])
            ->add('cleanSheets', NumberType::class, [
                'label' => 'Czyste konta',
            ])
            ->add('saves', NumberType::class, [
                'label' => 'Obrony',
                'attr' => [
                    'oninput' => 'setFloatValue(this)',
                    'type' => 'number',
                ],
            ])
            ->add('goalsConceded', NumberType::class, [
                'label' => 'Stracone gole',
                'attr' => [
                    'oninput' => 'setFloatValue(this)',
                    'type' => 'number',
                ],
            ])
            ->add('penaltySaves', NumberType::class, [
                'label' => 'Obronione karne',
            ])
            ->add('shootAccuracy', NumberType::class, [
                'label' => 'Celność strzałów',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => ['class' => 'btn btn--sm'],
            ]);
    }
}

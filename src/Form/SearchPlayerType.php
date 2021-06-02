<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', ChoiceType::class, [
                'label' => 'Pozycja',
                'choices' => [
                   'Bramkarz' => 1,
                   'Środkowy obrońca' => 2,
                   'Boczny obrońca' => 3,
                   'Środkowy pomocnik' => 4,
                   'Skrzydłowy' => 5,
                   'Napastnik' => 6,
                ],
                'row_attr' => ['class' => 'positions'],
            ])
            ->add('age', ChoiceType::class, [
                'label' => 'Wiek',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'age'],
            ])
            ->add('height', ChoiceType::class, [
                'label' => 'Wzrost',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'height'],
            ])
            ->add('saves', ChoiceType::class, [
                'label' => 'Liczba interwencji',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'saves'],
            ])
            ->add('goalsConceded', ChoiceType::class, [
                'label' => 'Bramki stracone',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'goals-conceded'],
            ])
            ->add('cleanSheets', ChoiceType::class, [
                'label' => 'Czyste konta',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'clean-sheets'],
            ])
            ->add('penaltySaves', ChoiceType::class, [
                'label' => 'Obronione karne',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'penalty-saves'],
            ])
            ->add('errors', ChoiceType::class, [
                'label' => 'Błędy przy golach',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'errors'],
            ])
            ->add('speed', ChoiceType::class, [
                'label' => 'Szybkość',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'speed none'],
            ])
            ->add('goals', ChoiceType::class, [
                'label' => 'Strzelone gole',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'goals none'],
            ])
            ->add('assists', ChoiceType::class, [
                'label' => 'Asysty',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'assists none'],
            ])
            ->add('dualsWon', ChoiceType::class, [
                'label' => 'Pojedynki wygrane',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'duals-won none'],
            ])
            ->add('clearances', ChoiceType::class, [
                'label' => 'Przejęcia piłki',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'clearances none'],
            ])
            ->add('passes', ChoiceType::class, [
                'label' => 'Dokładność podań',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'passes none'],
            ])
            ->add('touches', ChoiceType::class, [
                'label' => 'Dotknięcia piłki',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'touches none'],
            ])
            ->add('crosses', ChoiceType::class, [
                'label' => 'Dośrodkowania',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'crosses none'],
            ])
            ->add('dribbles', ChoiceType::class, [
                'label' => 'Drybling',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'dribbles none'],
            ])
            ->add('chances', ChoiceType::class, [
                'label' => 'Wykreowane szanse',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'chances none'],
            ])
            ->add('shoots', ChoiceType::class, [
                'label' => 'Celne strzały',
                'choices' => [
                   'Waga 1' => 1,
                   'Waga 2' => 2,
                   'Waga 3' => 3,
                   'Waga 4' => 4,
                   'Waga 5' => 5,
                ],
                'row_attr' => ['class' => 'shoots none'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Szukaj',
                'attr' => ['class' => 'btn btn--sm'],
            ]);
    }
}

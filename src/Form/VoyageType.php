<?php

namespace App\Form;

use App\Entity\Planet;
use App\Entity\Voyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);
        $builder
            ->add('purpose')
            ->add('leaveAt', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'data-controller' => 'datepicker',
                ]
            ])
            ->add('planet', null, [
                'choice_label' => 'name',
                'placeholder' => 'Choose a planet',
                //'autocomplete' => true,
            ])
            ->addDependent('wormholeUpgrade', ['planet'], function (DependentField $field, ?Planet $planet) {
                if (!$planet || $planet->isInMilkyWay()) {
                    return;
                }

                $field->add(ChoiceType::class, [
                    'choices' => [
                        'Yes' => true,
                        'No' => false,
                    ],
                ]);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}

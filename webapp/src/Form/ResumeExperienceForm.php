<?php

namespace App\Form;

use App\Entity\ResumeExperience;
use App\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResumeExperienceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => array_flip([
                    ResumeExperience::TYPE_PRO => 'Expérience',
                    ResumeExperience::TYPE_STUDIES => 'Etude',
                ]),
                'label' => 'Type d\'expérience',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('name', TextType::class, [
                'empty_data' => '',
                'label' => 'Titre, intitulé de poste...',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('company', TextType::class, [
                'empty_data' => '',
                'label' => 'Entreprise, école, université...',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('localization', TextType::class, [
                'empty_data' => '',
                'label' => 'Localisation',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(allowNull: true),
                ],
            ])
            ->add('startedAt', DateType::class, [
                'label' => 'Date de début',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('endedAt', DateType::class, [
                'required' => false,
                'label' => 'Date de fin',
                'constraints' => [
                    new NotBlank(allowNull: true),
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            /** @var ResumeExperience */
            $data = $event->getData();
            $form = $event->getForm();

            $startedAt = $data->getStartedAt();
            $endedAt = $data->getEndedAt();

            if (!empty($endedAt)) {
                if ($startedAt >= $endedAt) {
                    $form->get('startedAt')->addError(new FormError('La date de début ne peut-être supérieure ou égale à celle de fin'));
                }

                if ($endedAt <= $startedAt) {
                    $form->get('endedAt')->addError(new FormError('La date de fin ne peut-être inférieure ou égale à celle de début'));
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResumeExperience::class,
        ]);
    }
}

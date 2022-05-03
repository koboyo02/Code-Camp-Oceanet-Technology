<?php

namespace App\Form;

use App\Data\ResumeCrudData;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResumeForm extends AbstractSwupForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'empty_data' => '',
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('lastName', TextType::class, [
                'empty_data' => '',
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'empty_data' => '',
                'label' => 'Adresse mail',
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255),
                ],
            ])
            ->add('phone', TextType::class, [
                'empty_data' => '',
                'label' => 'Téléphone',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('address', ResumeAddressForm::class)
            ->add('skills', TextareaType::class, [
                'empty_data' => '',
                'label' => 'Compétences',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Suivant',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResumeCrudData::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'resume';
    }
}

<?php

namespace App\Form;

use App\Entity\ResumeAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResumeAddressForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'empty_data' => '',
                'label' => 'Adresse',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('city', TextType::class, [
                'empty_data' => '',
                'label' => 'Ville',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('zipCode', NumberType::class, [
                'empty_data' => '',
                'label' => 'Code postal',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('country', TextType::class, [
                'empty_data' => '',
                'label' => 'Pays',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResumeAddress::class,
        ]);
    }
}

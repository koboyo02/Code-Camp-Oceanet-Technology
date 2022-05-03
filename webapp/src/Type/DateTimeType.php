<?php

namespace App\Type;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateTimeType extends TextType implements DataTransformerInterface
{
    public static string $format = 'd/m/Y H:i';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this);
    }

    public function transform($data): string
    {
        if ($data instanceof \DateTimeInterface) {
            return $data->format(self::$format);
        }

        return '';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('attr', [
            'is' => 'datetime-picker',
            'date-format' => self::$format,
        ]);
    }

    public function reverseTransform($data): ?\DateTimeImmutable
    {
        if (1 === preg_match('/^([0-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/(2[0-9]{3}) ([0-1][0-9]|[2][0-3]):([0-5][0-9])$/', $data)) {
            if (false !== $date = \DateTimeImmutable::createFromFormat(self::$format, $data)) {
                return $date;
            }
        }

        return null;
    }
}

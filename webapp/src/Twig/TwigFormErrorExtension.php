<?php

namespace App\Twig;

use Symfony\Component\Form\FormView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigFormErrorExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('form_error', [$this, 'getError']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('form_field_get_error', [$this, 'getError']),
        ];
    }

    /**
     * Permet de retourner la première erreur
     *  dé l'entité passé en paramètre.
     *
     * @param mixed $value
     */
    public function getError($value): string
    {
        if (!$value instanceof FormView || 0 === $value->vars['errors']->count()) {
            return '';
        }

        return $value->vars['errors']->offsetGet(0)->getMessage();
    }
}

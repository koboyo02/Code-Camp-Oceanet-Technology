<?php

namespace App\Data;

use App\Entity\Resume;
use App\Form\ResumeExperiencesFormType;

final class ResumeExperiencesData extends AbstractCrudData
{
    public array $experiences;

    public function getEntity(): Resume
    {
        return $this->entity;
    }

    public function getFormClass(): string
    {
        return ResumeExperiencesFormType::class;
    }
}

<?php

namespace App\Data;

use App\Entity\Resume;
use App\Entity\ResumeAddress;
use App\Form\ResumeForm;

final class ResumeCrudData extends AbstractCrudData
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $phone;
    public string $skills;
    public ?ResumeAddress $address;

    public function getEntity(): Resume
    {
        return $this->entity;
    }

    public function getFormClass(): string
    {
        return ResumeForm::class;
    }
}

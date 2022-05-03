<?php

namespace App\Event;

use App\Entity\Resume;

final class ResumeSubmittedEvent
{
    public function __construct(public Resume $resume)
    {
    }
}

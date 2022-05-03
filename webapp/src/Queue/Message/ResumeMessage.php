<?php

namespace App\Queue\Message;

final class ResumeMessage
{
    public function __construct(public readonly string $resumeId)
    {
    }
}

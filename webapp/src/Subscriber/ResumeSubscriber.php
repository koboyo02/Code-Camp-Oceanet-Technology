<?php

namespace App\Subscriber;

use App\Event\ResumeSubmittedEvent;
use App\Queue\Message\ResumeMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class ResumeSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ResumeSubmittedEvent::class => 'onResumeSubmitted',
        ];
    }

    public function onResumeSubmitted(ResumeSubmittedEvent $event): void
    {
        // add a new job to the queue
        $this->messageBus->dispatch(new ResumeMessage($event->resume->getId()));
    }
}

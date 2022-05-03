<?php

namespace App\Service;

use App\Entity\Resume;
use App\Event\ResumeSubmittedEvent;
use App\Repository\ResumeRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

final class ResumeService
{
    private readonly Session $session;

    public function __construct(
        readonly RequestStack $requestStack,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ResumeRepository $repository,
    ) {
        $this->session = $requestStack->getCurrentRequest()->getSession();
    }

    public function current(): ?Resume
    {
        if (null === $resumeHash = $this->session->get('resume')) {
            return null;
        }

        return $this->repository->findOneBy(['hash' => $resumeHash]);
    }

    public function new(): Resume
    {
        $resume = (new Resume())
            ->setHash(bin2hex(random_bytes(8)))
        ;
        $this->session->set('resume', $resume->getHash());

        return $resume;
    }

    public function submit(Resume $resume): void
    {
        $this->session->remove('resume');
        $resume->setStatus(Resume::STATUS_SUBMITTED);
        $this->repository->add($resume, true);

        $this->eventDispatcher->dispatch(new ResumeSubmittedEvent($resume));
    }
}

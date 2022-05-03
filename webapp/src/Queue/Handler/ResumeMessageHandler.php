<?php

namespace App\Queue\Handler;

use App\Entity\Resume;
use App\Queue\Message\ResumeMessage;
use App\Repository\ResumeRepository;
use App\Service\PdfGeneratorService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Environment;

final class ResumeMessageHandler implements MessageHandlerInterface, ServiceSubscriberInterface
{
    public function __construct(
        private readonly PdfGeneratorService $pdfGeneratorService,
        private readonly ResumeRepository $repository,
        private readonly Environment $twig,
    ) {
    }

    public function __invoke(ResumeMessage $message): void
    {
        $resume = $this->repository->findByIdFullyLoaded($message->resumeId);
        if (null === $resume) {
            return;
        }

        $resumeHash = $resume->getHash();

        $this->pdfGeneratorService->generate(
            $this->twig->render('pdf/resume.html.twig', compact('resume')),
            "pdfs/{$resumeHash}/resume.pdf",
        );

        $this->pdfGeneratorService->generate(
            $this->twig->render('pdf/resume_blind.html.twig', compact('resume')),
            "pdfs/{$resumeHash}/resume_blind.pdf",
        );

        $resume->setStatus(Resume::STATUS_COMPLETED);
        $this->repository->add($resume, true);
    }

    public static function getSubscribedServices(): array
    {
        return [];
    }
}

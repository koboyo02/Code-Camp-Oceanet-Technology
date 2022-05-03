<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Repository\ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/resume')]
class AdminResumeController extends AbstractController
{
    public function __construct(private readonly string $projectDir)
    {
    }

    #[Route('', name: 'app_admin_resumes')]
    public function index(Request $request, ResumeRepository $repository): Response
    {
        $query = $request->query->get('q');
        if (empty($query)) {
            $resumes = $repository->findBy(['status' => Resume::STATUS_COMPLETED], ['createdAt' => 'DESC']);
        } else {
            $resumes = [];
            $result = $repository->findOneBy(['hash' => $query]);
            if (null !== $result) {
                $resumes[] = $result;
            }
        }

        return $this->render('admin_resume/index.html.twig', compact('resumes'));
    }

    #[Route('/download/{hash}', name: 'app_admin_resume_download')]
    public function download(Request $request, ResumeRepository $repository, string $hash): Response
    {
        $resume = $repository->findByHash($hash);
        if (null === $resume) {
            throw $this->createNotFoundException();
        }
        $type = $request->query->get('type', 'normal');
        $filename = match ($type) {
            'blind' => 'resume_blind.pdf',
            default => 'resume.pdf',
        };

        $file = $this->projectDir."/pdfs/{$hash}/{$filename}";
        if (!file_exists($file)) {
            throw $this->createNotFoundException();
        }

        return new Response(file_get_contents($file), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"resume_{$type}.pdf\"",
        ]);
    }
}

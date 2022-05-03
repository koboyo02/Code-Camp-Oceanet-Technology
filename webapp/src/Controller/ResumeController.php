<?php

namespace App\Controller;

use App\Data\ResumeCrudData;
use App\Data\ResumeExperiencesData;
use App\Form\ResumeExperiencesFormType;
use App\Repository\ResumeExperienceRepository;
use App\Service\ResumeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/resume')]
final class ResumeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ResumeService $resumeService,
    ) {
    }

    #[Route('', name: 'app_resume')]
    public function index(Request $request): Response
    {
        $resume = $this->resumeService->current();
        if (null === $resume) {
            $resume = $this->resumeService->new();
        }

        $data = new ResumeCrudData($resume);

        $form = $this->createForm($data->getFormClass(), $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data->hydrate();
            $this->em->persist($resume);
            $this->em->flush();

            return $this->redirectToRoute('app_resume_experiences');
        }

        return $this->render('resume/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/exp', name: 'app_resume_experiences')]
    public function experiences(Request $request, ResumeExperienceRepository $repository): Response
    {
        $resume = $this->resumeService->current();
        if (null === $resume) {
            return $this->redirectToRoute('app_resume');
        }

        $data = new ResumeExperiencesData($resume);
        $form = $this->createForm(ResumeExperiencesFormType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data->hydrate();

            $this->em->persist($resume);
            $this->em->flush();

            return $this->redirectToRoute('app_resume_confirm');
        }

        return $this->render('resume/experiences.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/confirm', name: 'app_resume_confirm')]
    public function confirm(Request $request): Response
    {
        $resume = $this->resumeService->current();
        if (null === $resume) {
            return $this->redirectToRoute('app_resume');
        }

        if ($request->isMethod('POST')) {
            $this->resumeService->submit($resume);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('resume/confirm.html.twig', [
            'resume' => $resume,
        ]);
    }
}

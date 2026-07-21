<?php

namespace App\Controller;

use App\Entity\Runner;
use App\Form\RunnerForm;
use App\Repository\RunnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/runner')]
final class RunnerController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_runner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Runner $runner, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RunnerForm::class, $runner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_runner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('runner/edit.html.twig', [
            'runner' => $runner,
            'form' => $form,
        ]);
    }
}

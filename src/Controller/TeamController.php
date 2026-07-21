<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Runner;
use App\Entity\Team;
use App\Form\TeamForm;
use App\Repository\RunnerRepository;
use App\Repository\TeamRepository;
use App\Repository\TrailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event/')]
final class TeamController extends AbstractController
{
    #[Route('{slug}/team', name: 'app_team_index', methods: ['GET'])]
    public function index(
        #[MapEntity(mapping: ['slug' => 'slug'])] Event $event,
        TeamRepository $teamRepository,
        RunnerRepository $runnerRepository,
    ): Response
    {
        $teams = $teamRepository->findAllWithTrails($event->getId());
        $index = 0;
        foreach ($teams as $team) {
            $runners = $runnerRepository->findAllByTeam($team[0]->getId());
            /* put runners with the associated team */
            $teams[$index][1] = $runners;
            $index++;
        }
        return $this->render('team/index.html.twig', [
            'teams' => $teams,
            'event' => $event,
        ]);
    }

    #[Route('{slug}/team/new', name: 'app_team_new', methods: ['GET', 'POST'])]
    public function new(
        #[MapEntity(mapping: ['slug' => 'slug'])] Event $event,
        Request $request,
        EntityManagerInterface $entityManager,
        TrailRepository $trailRepository
    ): Response
    {
        $team = new Team();
        // defining the 2 team members manually (Technical debt, see Documentation of event creation)
        $captain = new Runner();
        $team->getRunners()->add($captain);
        $teammate = new Runner();
        $team->getRunners()->add($teammate);

        $form = $this->createForm(TeamForm::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
            'event' => $event,
        ]);
    }

    #[Route('{slug}/team/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit(
        #[MapEntity(mapping: ['slug' => 'slug'])] Event $event,
        Request $request,
        Team $team,
        EntityManagerInterface $entityManager
    ): Response
    {
        $form = $this->createForm(TeamForm::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
            'event' => $event,
        ]);
    }

    #[Route('{slug}/team/{id}', name: 'app_team_delete', methods: ['POST'])]
    public function delete(
        #[MapEntity(mapping: ['slug' => 'slug'])] Event $event,
        Request $request,
        Team $team,
        EntityManagerInterface $entityManager,
        RunnerRepository $runnerRepository
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($team);
            $runners = $runnerRepository->findAllByTeam($team->getId());
            foreach ($runners as $runner) {
                $entityManager->remove($runner);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_team_index', ['slug' => $event->getSlug()], Response::HTTP_SEE_OTHER);
    }
}

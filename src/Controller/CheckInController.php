<?php

namespace App\Controller;

use App\DTO\RunnerPointedDTO;
use App\Entity\Event;
use App\Form\CheckinForm;
use App\Form\ManualCheckinForm;
use App\Repository\RunnerRepository;
use App\Repository\TeamRepository;
use App\Repository\TrailRepository;
use App\Services\CheckInHandler;
use App\Services\MatcherService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ObjectMapper\ObjectMapper;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/event', name: 'app_event_')]
final class CheckInController extends AbstractController
{
    /* Route to test chip assignment before the starting of the event */
    #[Route('/{slug}/verif', name: 'verif', methods: ['GET', 'POST'])]
    public function verif (
        #[MapEntity(mapping: ['slug' => 'slug'])] Event $event,
        Request $request,
        RunnerRepository $runnerRepository,
        TeamRepository $teamRepository,
        TrailRepository $trailRepository,
        ObjectMapperInterface $mapper
    ): Response
    {
        $form = $this->createForm(CheckinForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $runnerIfExist = $runnerRepository->findByChip($data->checkin);
            $dtoForSimplifiedAccess = new RunnerPointedDTO(); // instance pour accéder plus facilement aux propriétés du dto
            /** Return state of the data to be displayed on web interface or false if no runner was found. */
            $runnerReturnabled = false;
            if ($runnerIfExist) {
                $team = $teamRepository->findByFK($runnerIfExist->getFkTeamId());

                $runnerReturnabled = $mapper->map($runnerIfExist, $dtoForSimplifiedAccess);
                $trail = $trailRepository->getTrailByRunnerId($runnerIfExist->getId());
                $dtoForSimplifiedAccess->trail = $trail->getName();
                $dtoForSimplifiedAccess->team_id = $team->getId();
            }
            /* Here, the returned data affects how JavaScript displays the data */
            return $this->json($runnerReturnabled, Response::HTTP_OK);
        }

        return $this->render('check/verif.html.twig', [
            'form' => $form,
            'event' => $event
        ]);
    }

    #[Route('/{slug}/pointage', name: 'checkin')]
    public function checkin (
        #[MapEntity(mapping: ['slug' => 'slug'])] Event $event,
        Request $request,
        CheckInHandler $checkinHandler,
        MatcherService $matcher
    ): Response
    {
        $form = $this->createForm(CheckinForm::class);
        $manualForm = $this->createForm(ManualCheckinForm::class);
        $manualForm->handleRequest($request);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Initialization here to not lose time with intermediate.s query.ies to the database
            $dateNow = new DateTimeImmutable('now', new \DateTimeZone('UTC'));

            $runnerFound = $checkinHandler->searchRunner(chip: $data->checkin);

            if ($runnerFound) {
                $returnableRunner = $matcher->checkInLogic($runnerFound, $dateNow);
            }
            return $this->json($returnableRunner??false, Response::HTTP_OK);
        }

        if ($manualForm->isSubmitted() && $manualForm->isValid()) {
            $data = $manualForm->getData();
            $dateNow = new DateTimeImmutable('now', new \DateTimeZone('UTC'));

            $runner = $checkinHandler->searchRunner(bib_number: $data->bib_number, role: $data->captain);
            if ($runner) {
                $returnableRunner = $matcher->checkInLogic($runner, $dateNow);
            }
            return $this->json($returnableRunner??false, Response::HTTP_OK);
        }

        return $this->render('check/checkin.html.twig', [
            'form' => $form,
            'manualForm' => $manualForm,
            'event' => $event
        ]);
    }

    /* Testing route reset all times of everyone. Available for dev only
     */
    #[Route('/{slug}/reset', name: 'reset', env: ['dev', 'test'])]
    public function reset (#[MapEntity(mapping: ['slug' => 'slug'])] Event $event, TeamRepository $teamRepository, RunnerRepository $runnerRepository, EntityManagerInterface $entityManager)
    {
        $allRunners = $runnerRepository->findAll();
        foreach ($allRunners as $runner) {
            if ($runner->getPersonalTime()) {
                $runner->setPersonalTime(null);
                $entityManager->persist($runner);
            }
        }
        $allTeams = $teamRepository->findAll();
        foreach ($allTeams as $team) {
            if ($team->getFinalTime()) {
                $team->setFinalTime(null);
                $entityManager->persist($team);
            }
        }
        $entityManager->flush();
        return $this->redirectToRoute('app_event_checkin', ['slug' => $event->getSlug()]);
    }
}
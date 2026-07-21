<?php

namespace App\Controller;

use App\DTO\RunnerPointedDTO;
use App\Entity\Event;
use App\Form\CheckinForm;
use App\Repository\RunnerRepository;
use App\Repository\TeamRepository;
use App\Services\CheckInHandler;
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
    #[Route('/{slug}/verif', name: 'verif', methods: ['GET', 'POST'])]
    public function verif (#[MapEntity(mapping: ['slug' => 'slug'])] Event $event, Request $request, RunnerRepository $runnerRepository, ObjectMapperInterface $mapper): Response
    {
        $form = $this->createForm(CheckinForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $runner = $runnerRepository->findByChip($data->checkin);
            /** Return state of the data to be displayed on web interface or false if no runner was found. */
            $runnerReturnabled = false;
            if ($runner) {
                $runnerReturnabled = $mapper->map($runner, RunnerPointedDTO::class);
            }
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
        RunnerRepository $runnerRepository,
        ObjectMapperInterface $mapper,
        CheckInHandler $checkinHandler
    ): Response
    {
        $form = $this->createForm(CheckinForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $runner = $checkinHandler->runnerPointer($data->checkin);
            $team = $checkinHandler->setTimeToTeam($runner);
            /** Returns the data to be displayed on web interface or false if no runner was found. */
            $returnableRunner = false;
            if ($runner) {
                $returnableRunner = $mapper->map($runner, RunnerPointedDTO::class);

            }
            /** @var $finalTime
             * @type DateTimeImmutable */
            $finalTime = null;
            if ($team) $finalTime = $team->getFinalTime();
            return $this->json([$returnableRunner, $finalTime ?: ''], Response::HTTP_OK);
        }

        return $this->render('check/checkin.html.twig', [
            'form' => $form,
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
<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\TeamRepository;
use App\Repository\TrailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RankingController extends AbstractController
{
    #[Route('/event/{slug}/ranking', name: 'app_ranking')]
    public function index(
        #[MapEntity(mapping: ['slug' => 'slug'])] Event $event,
        TeamRepository $teamRepository,
        TrailRepository $trailRepository,
    ): Response
    {
        $trails = $trailRepository->findByEvent($event);
        $teams =  $teamRepository->findOrderByTime($trails[0]);
//        dd($teams);

        return $this->render('ranking/index.html.twig', [
            'ranked_teams' => $teams,
        ]);
    }

    /* Testing route for filled teams records with time values
     */
    #[Route('/event/{slug}/rankup', name: 'app_rankup', env: ['dev', 'test'])]
    public function rankup(
        #[MapEntity(mapping: ['slug' => 'slug'])] Event $event,
        TeamRepository $teamRepository,
        TrailRepository $trailRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $teams =  $teamRepository->findAllByEvent($event->getId());
        $minutes = 30;
        foreach ($teams as $team) {
            if (!$team->getFinalTime()) {
                $team->setFinalTime((new \DateTimeImmutable())->setTime(2, $minutes, 41));
                $minutes += 5;
            }
            $entityManager->persist($team);
        }
        $entityManager->flush();
        $entityManager->clear();

        return $this->json('ok', Response::HTTP_OK);
    }
}

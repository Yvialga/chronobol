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

}

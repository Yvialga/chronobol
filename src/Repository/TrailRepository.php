<?php

namespace App\Repository;

use App\Entity\Trail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trail>
 */
class TrailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trail::class);
    }

    public function findByEvent(string $eventSlug) : array
    {
        return $this->createQueryBuilder('t')
            ->where('t.fk_event_id = :eventSlug')
            ->setParameter('eventSlug', $eventSlug)
            ->getQuery()
            ->getResult();
    }

}

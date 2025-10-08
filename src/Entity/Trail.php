<?php

namespace App\Entity;

use App\Repository\TrailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrailRepository::class)]
class Trail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $trail_name = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $start_time = null;

    #[ORM\ManyToOne(inversedBy: 'event_trail_id')]
    #[ORM\JoinColumn(nullable: false, name: 'fk_event_id')]
    private ?Event $fk_event_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrailName(): ?string
    {
        return $this->trail_name;
    }

    public function setTrailName(string $trail_name): static
    {
        $this->trail_name = $trail_name;

        return $this;
    }

    public function getStartTime(): ?\DateTime
    {
        return $this->start_time;
    }

    public function setStartTime(?\DateTime $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getFkEventId(): ?Event
    {
        return $this->fk_event_id;
    }

    public function setFkEventId(?Event $fk_event_id): static
    {
        $this->fk_event_id = $fk_event_id;

        return $this;
    }
}

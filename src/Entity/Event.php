<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $event_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $event_date = null;

    #[ORM\Column(length: 255)]
    private ?string $event_slug = null;

    /**
     * @var Collection<int, Trail>
     */
    #[ORM\OneToMany(targetEntity: Trail::class, mappedBy: 'fk_event_id')]
    private Collection $event_trail_id;

    public function __construct()
    {
        $this->event_trail_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setEventName(string $event_name): static
    {
        $this->event_name = $event_name;

        return $this;
    }

    public function getEventDate(): ?\DateTime
    {
        return $this->event_date;
    }

    public function setEventDate(\DateTime $event_date): static
    {
        $this->event_date = $event_date;

        return $this;
    }

    public function getEventSlug(): ?string
    {
        return $this->event_slug;
    }

    public function setEventSlug(string $event_slug): static
    {
        $this->event_slug = $event_slug;

        return $this;
    }

    /**
     * @return Collection<int, Trail>
     */
    public function getEventTrailId(): Collection
    {
        return $this->event_trail_id;
    }

    public function addEventTrailId(Trail $eventTrailId): static
    {
        if (!$this->event_trail_id->contains($eventTrailId)) {
            $this->event_trail_id->add($eventTrailId);
            $eventTrailId->setFkEventId($this);
        }

        return $this;
    }

    public function removeEventTrailId(Trail $eventTrailId): static
    {
        if ($this->event_trail_id->removeElement($eventTrailId)) {
            // set the owning side to null (unless already changed)
            if ($eventTrailId->getFkEventId() === $this) {
                $eventTrailId->setFkEventId(null);
            }
        }

        return $this;
    }
}

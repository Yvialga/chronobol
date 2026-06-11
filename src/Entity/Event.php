<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Trail>
     */
    #[ORM\OneToMany(targetEntity: Trail::class, mappedBy: 'fk_event_id')]
    private Collection $fk_trail_id;

    public function __construct()
    {
        $this->fk_trail_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return Collection<int, Trail>
     */
    public function getFkTrailId(): Collection
    {
        return $this->fk_trail_id;
    }

    public function addEventTrailId(Trail $eventTrailId): static
    {
        if (!$this->fk_trail_id->contains($eventTrailId)) {
            $this->fk_trail_id->add($eventTrailId);
            $eventTrailId->setFkEventId($this);
        }

        return $this;
    }

    public function removeEventTrailId(Trail $eventTrailId): static
    {
        if ($this->fk_trail_id->removeElement($eventTrailId)) {
            // set the owning side to null (unless already changed)
            if ($eventTrailId->getFkEventId() === $this) {
                $eventTrailId->setFkEventId(null);
            }
        }

        return $this;
    }

}

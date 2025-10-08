<?php

namespace App\Entity;

use App\Repository\SpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpaceRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_SPACE_NAME', fields: ['space_name'])]
class Space
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $space_name = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'fk_space_id')]
    #[ORM\JoinColumn(name: 'fk_event_id')]
    private Collection $fk_event_id;

    #[ORM\Column(length: 255)]
    private ?string $space_slug = null;

    public function __construct()
    {
        $this->fk_event_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpaceName(): ?string
    {
        return $this->space_name;
    }

    public function setSpaceName(string $space_name): static
    {
        $this->space_name = $space_name;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getFkEventId(): Collection
    {
        return $this->fk_event_id;
    }

    public function addFkEventId(Event $fkEventId): static
    {
        if (!$this->fk_event_id->contains($fkEventId)) {
            $this->fk_event_id->add($fkEventId);
            $fkEventId->setFkSpaceId($this);
        }

        return $this;
    }

    public function removeFkEventId(Event $fkEventId): static
    {
        if ($this->fk_event_id->removeElement($fkEventId)) {
            // set the owning side to null (unless already changed)
            if ($fkEventId->getFkSpaceId() === $this) {
                $fkEventId->setFkSpaceId(null);
            }
        }

        return $this;
    }

    public function getSpaceSlug(): ?string
    {
        return $this->space_slug;
    }

    public function setSpaceSlug(string $space_slug): static
    {
        $this->space_slug = $space_slug;

        return $this;
    }
}

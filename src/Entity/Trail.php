<?php

namespace App\Entity;

use App\Repository\TrailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TrailRepository::class)]
class Trail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $start_time = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'fk_trail_id')]
    #[ORM\JoinColumn(nullable: false, name: 'fk_event_id')]
    private ?Event $fk_event_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'fk_trail_template_id')] /* To set the name of foreign key in the database, nullable: true,
                                                       because does not necessarily depend on TrailTemplate */
    private ?TrailTemplate $fk_trail_template_id = null;

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

    public function getStartTime(): ?\DateTime
    {
        return $this->start_time;
    }

    public function setStartTime(?\DateTime $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(): static
    {
        $this->created_at = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

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

    public function getFkTrailTemplateId(): ?TrailTemplate
    {
        return $this->fk_trail_template_id;
    }

    public function setFkTrailTemplateId(?TrailTemplate $fk_trail_template_id): static
    {
        $this->fk_trail_template_id = $fk_trail_template_id;

        return $this;
    }
}

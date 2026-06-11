<?php

namespace App\Entity;

use App\Enum\RunStateEnum;
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

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE ,nullable: true)]
    private ?\DateTimeImmutable $start_time = null;

    #[ORM\Column(enumType: RunStateEnum::class)]
    private ?RunStateEnum $run_state = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $member_number = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'fk_trail_id')]
    #[ORM\JoinColumn(name: 'fk_event_id', nullable: false)]
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

    public function getStartTime(): ?\DateTimeImmutable
    {
        return $this->start_time;
    }

    public function setStartTime(?\DateTimeImmutable $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getRunState(): ?RunStateEnum
    {
        return $this->run_state;
    }

    public function setRunState(RunStateEnum $run_state): static
    {
        $this->run_state = $run_state;

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

    public function getMemberNumber(): ?int
    {
        return $this->member_number;
    }

    public function setMemberNumber(int $member_number): static
    {
        $this->member_number = $member_number;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
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

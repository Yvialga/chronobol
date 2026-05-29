<?php

namespace App\Entity;

use App\Enum\CategoryEnum;
use App\Repository\TeamRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: CategoryEnum::class)]
    private ?CategoryEnum $category = null;

    #[ORM\Column]
    private bool $paid_registration = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $final_time = null;

    #[ORM\Column]
    private bool $deposit = false;

    #[ORM\Column]
    private bool $electric_bike = false;

    #[ORM\Column]
    private ?int $meal_count = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'fk_trail_id', nullable: false)]
    private ?Trail $fk_trail_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?CategoryEnum
    {
        return $this->category;
    }

    public function setCategory(CategoryEnum $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function isPaidRegistration(): bool
    {
        return $this->paid_registration;
    }

    public function setPaidRegistration(bool $paid_registration): static
    {
        $this->paid_registration = $paid_registration;

        return $this;
    }

    public function isDeposit(): bool
    {
        return $this->deposit;
    }

    public function setDeposit(bool $deposit): static
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function isElectricBike(): bool
    {
        return $this->electric_bike;
    }

    public function setElectricBike(bool $electric_bike): static
    {
        $this->electric_bike = $electric_bike;

        return $this;
    }

    public function getMealCount(): ?int
    {
        return $this->meal_count;
    }

    public function setMealCount(?int $meal_count): static
    {
        $this->meal_count = $meal_count;

        return $this;
    }

    public function getFinalTime(): ?\DateTime
    {
        return $this->final_time;
    }

    public function setFinalTime(?\DateTime $final_time): static
    {
        $this->final_time = $final_time;

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

    public function getFkTrailId(): ?Trail
    {
        return $this->fk_trail_id;
    }

    public function setFkTrailId(?Trail $fk_trail_id): static
    {
        $this->fk_trail_id = $fk_trail_id;

        return $this;
    }
}

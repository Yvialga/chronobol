<?php

namespace App\Entity;

use App\Repository\TrailTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TrailTemplateRepository::class)]
class TrailTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $model_name = null;

    #[ORM\Column]
    private ?int $min_age = null;

    #[ORM\Column(nullable: true)]
    private ?int $max_age = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelName(): ?string
    {
        return $this->model_name;
    }

    public function setModelName(string $model_name): static
    {
        $this->model_name = $model_name;

        return $this;
    }

    public function getMinAge(): ?int
    {
        return $this->min_age;
    }

    public function setMinAge(int $min_age): static
    {
        $this->min_age = $min_age;

        return $this;
    }

    public function getMaxAge(): ?int
    {
        return $this->max_age;
    }

    public function setMaxAge(?int $max_age): static
    {
        $this->max_age = $max_age;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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
}

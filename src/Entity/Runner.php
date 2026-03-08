<?php

namespace App\Entity;

use App\Enum\CategoryEnum;
use App\Enum\StatusEnum;
use App\Repository\RunnerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: RunnerRepository::class)]
class Runner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?int $age = null;

    #[ORM\Column(enumType: CategoryEnum::class)]
    private ?int $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(index: true)]
    private ?int $bib_number = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true, unique: true, index: true)]
    private ?string $chip_id = null;

    #[ORM\Column]
    private ?bool $is_captain = null;

    #[ORM\Column]
    private ?bool $is_underage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $medical_certificate = null;

    #[ORM\Column]
    private ?bool $parentale_consent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $personal_time = null;

    #[ORM\Column]
    private ?bool $is_validate = null;

    #[ORM\Column(enumType: StatusEnum::class)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'fk_team_id')]
    private ?Team $fk_team_id = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBibNumber(): ?int
    {
        return $this->bib_number;
    }

    public function setBibNumber(int $bib_number): static
    {
        $this->bib_number = $bib_number;

        return $this;
    }

    public function getChipId(): ?string
    {
        return $this->chip_id;
    }

    public function setChipId(?string $chip_id): static
    {
        $this->chip_id = $chip_id;

        return $this;
    }

    public function isCaptain(): ?bool
    {
        return $this->is_captain;
    }

    public function setIsCaptain(bool $is_captain): static
    {
        $this->is_captain = $is_captain;

        return $this;
    }

    public function isUnderage(): ?bool
    {
        return $this->is_underage;
    }

    public function setIsUnderage(bool $is_underage): static
    {
        $this->is_underage = $is_underage;

        return $this;
    }

    public function isMedicalCertificate(): ?bool
    {
        return $this->medical_certificate;
    }

    public function setMedicalCertificate(bool $medical_certificate): static
    {
        $this->medical_certificate = $medical_certificate;

        return $this;
    }

    public function isParentaleConsent(): ?bool
    {
        return $this->parentale_consent;
    }

    public function setParentaleConsent(?bool $parentale_consent): static
    {
        $this->parentale_consent = $parentale_consent;

        return $this;
    }

    public function getPersonalTime(): ?\DateTime
    {
        return $this->personal_time;
    }

    public function setPersonalTime(?\DateTime $personal_time): static
    {
        $this->personal_time = $personal_time;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

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

    public function isValidate(): ?bool
    {
        return $this->is_validate;
    }

    public function setIsValidate(bool $is_validate): static
    {
        $this->is_validate = $is_validate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getFkTeamId(): ?Team
    {
        return $this->fk_team_id;
    }

    public function setFkTeamId(?Team $fk_team_id): static
    {
        $this->fk_team_id = $fk_team_id;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Enum\GenderEnum;
use App\Enum\StatusEnum;
use App\Repository\RunnerRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: RunnerRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'default')]
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

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $age = null;

    #[ORM\Column(enumType: GenderEnum::class)]
    private ?GenderEnum $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true, index: true)]
    private ?int $bib_number = null;

    #[ORM\Column(type: Types::BIGINT, unique: true, nullable: true, index: true)]
    private ?string $chip_id = null;

    #[ORM\Column]
    private bool $is_captain = false;

    #[ORM\Column]
    private bool $is_underage = false;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $medical_certificate = null;

    #[ORM\Column]
    private bool $parental_consent = false;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $personal_time = null;

    #[ORM\Column]
    private bool $is_validate = false;

    #[ORM\Column(enumType: StatusEnum::class)]
    private ?StatusEnum $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'runners')]
    #[ORM\JoinColumn(name: 'fk_team_id', nullable: true)]
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

    public function getAge(): ?\DateTimeImmutable
    {
        return $this->age;
    }

    public function setAge(\DateTimeImmutable $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?GenderEnum
    {
        return $this->gender;
    }

    public function setGender(GenderEnum $gender): static
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

    public function isCaptain(): bool
    {
        return $this->is_captain;
    }

    public function setIsCaptain(bool $is_captain): static
    {
        $this->is_captain = $is_captain;

        return $this;
    }

    public function isUnderage(): bool
    {
        return $this->is_underage;
    }

    public function setIsUnderage(bool $is_underage): static
    {
        $this->is_underage = $is_underage;

        return $this;
    }

    public function isMedicalCertificate(): bool
    {
        return $this->medical_certificate;
    }

    public function setMedicalCertificate(bool $medical_certificate): static
    {
        $this->medical_certificate = $medical_certificate;

        return $this;
    }

    public function isParentalConsent(): bool
    {
        return $this->parental_consent;
    }

    public function setParentalConsent(bool $parental_consent): static
    {
        $this->parental_consent = $parental_consent;

        return $this;
    }

    public function getPersonalTime(): ?\DateTimeImmutable
    {
        return $this->personal_time;
    }

    public function setPersonalTime(?\DateTimeImmutable $personal_time): static
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

    #[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updated_at = new DateTimeImmutable('now', new \DateTimeZone('UTC'));

        return $this;
    }

    public function isValidate(): bool
    {
        return $this->is_validate;
    }

    public function setIsValidate(bool $is_validate): static
    {
        $this->is_validate = $is_validate;

        return $this;
    }

    public function getStatus(): ?StatusEnum
    {
        return $this->status;
    }

    public function setStatus(?StatusEnum $status): void
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

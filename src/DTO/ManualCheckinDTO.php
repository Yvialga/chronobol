<?php

namespace App\DTO;

use App\Enum\TeamRole;
use Symfony\Component\Validator\Constraints as Assert;

class ManualCheckinDTO
{
    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    public int $bib_number;

    #[Assert\NotBlank(message: "Sélectionner le rôle du compétiteur")]
    public TeamRole $captain;

}
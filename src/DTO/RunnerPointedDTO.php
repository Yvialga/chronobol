<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**It is intended for the “return” statement so that it can be sent to the templates,
 * which will then display the information correctly .
 */
class RunnerPointedDTO
{
    #[Assert\NotBlank]
    public string $bib_number;

    public string $firstname;

    public string $lastname;

    public ?\DateTimeImmutable $personal_time = null;

    public ?\DateTimeImmutable $final_time = null;

}
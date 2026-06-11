<?php

namespace App\Enum;

enum RunStateEnum : string
{
    case PLANNED = 'programmée';
    case IN_PROGRESS = 'en cours';
    case RACE_OVER = 'finie';
}

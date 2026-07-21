<?php

namespace App\Enum;

/** Enums for the state of each event.
 */
enum RunStateEnum : string
{
    case PLANNED = 'programmée';
    case IN_PROGRESS = 'en cours';
    case RACE_OVER = 'finie';
}

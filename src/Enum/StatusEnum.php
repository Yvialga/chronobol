<?php

namespace App\Enum;

/** Enums for Runner records.
 */
enum StatusEnum: string {

    case invalid = "invalide";
    case register = "inscrit";
    case abandon = "abandonne";
    case absent = "absent";
}
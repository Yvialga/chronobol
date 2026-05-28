<?php

namespace App\Enum;

enum StatusEnum: string {

    case invalid = "invalide";
    case register = "inscrit";
    case abandon = "abandonne";
    case absent = "absent";
}
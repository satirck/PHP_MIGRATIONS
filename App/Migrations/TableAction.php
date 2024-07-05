<?php

declare(strict_types=1);

namespace App\Migrations;

enum TableAction
{
    case Empty;
    case CREATE;
    case UPDATE;
    case REMOVE;
}

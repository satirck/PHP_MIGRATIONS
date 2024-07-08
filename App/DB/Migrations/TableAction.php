<?php

declare(strict_types=1);

namespace App\DB\Migrations;

enum TableAction
{
    case EMPTY;
    case CREATE;
    case UPDATE;
    case REMOVE;
}

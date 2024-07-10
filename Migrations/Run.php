<?php

declare(strict_types=1);

namespace App\Migrations;

require_once sprintf(
    '%s/../vendor/autoload.php',
    __DIR__,
);

use DateTime;
use DirectoryIterator;

function loadFiles(): array
{
    $iterator = new DirectoryIterator(
        sprintf('%s/Files/', __DIR__)
    );
    $files = [];

    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isFile() &&
            preg_match(
                '/^(\d{4}_\d{2}_\d{1,2}_\d{1,2}_\d{1,2})-/',
                $fileInfo->getFilename(),
                $matches)
        ) {
            $datetimeStr = str_replace('_', '-', $matches[1]);
            $datetime = DateTime::createFromFormat('Y-m-d-H-i', $datetimeStr);
            if ($datetime) {
                $files[$matches[1]] = sprintf(
                    '%s/Files/%s',
                    __DIR__,
                    $fileInfo->getFilename()
                );
            }
        }
    }
    return $files;
}

if ($argc != 2) {
    echo 'Usage: php /var/www/html/Migrations/Run [down|up]';
    echo PHP_EOL;
    die();
}

$direction = $argv[1];

$files = loadFiles();
if ($files === []) {
    echo 'No migrations to run';
    echo PHP_EOL;
    return;
}

if ($direction === 'up') {
    require_once sprintf('%s/Up.php', __DIR__);
    return;
}

require_once sprintf('%s/Down.php', __DIR__);
return;
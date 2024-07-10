<?php

declare(strict_types=1);

namespace App\Migrations;

use App\DB\DBConnector;
use App\DB\Migrations\Migration;
use App\Exceptions\Migrations\DBNameNotSetException;
use App\Exceptions\Migrations\MigrationActionNotSetException;
use App\Exceptions\Migrations\MigrationEmptyFieldsException;
use App\Exceptions\Migrations\TableNameNotSetException;
use PDO;
use Throwable;

/**
 * @var $file string[] is an array of files, where keys are time stamp like yyyy_mm_dd_hh_mm
 * and the value is a string with full path
 */
if (!isset($files)) {
    echo 'array of possible files must be initiated';
    echo PHP_EOL;

    die();
}

/**
 * @throws TableNameNotSetException
 * @throws DBNameNotSetException
 * @throws MigrationActionNotSetException
 * @throws MigrationEmptyFieldsException
 */
function getSQLQuery(Migration $migration): string
{
    $migration->down();
    return $migration->table->getSQLQuery();
}

/**
 * @throws TableNameNotSetException
 * @throws DBNameNotSetException
 * @throws MigrationActionNotSetException
 * @throws MigrationEmptyFieldsException
 */
function applyMigration(string $filePath, string $key, PDO $pdo): void
{
    $class = require_once $filePath;

    if (!(is_object($class) && is_subclass_of($class, Migration::class))) {
        return;
    }

    $sql = getSQLQuery($class);

    if ($sql === '') {
        return;
    }

    $name = basename($filePath, '.php');
    executeSQL($pdo, $name, $sql);
    removeMigrationInfo(
        $pdo,
        $key,
    );
}

function executeSQL(PDO $pdo, string $name, string $sql): void
{
    try {
        $pdo->prepare($sql)->execute();

        echo sprintf(
            'Migration %s is deleted. Moving to another.%s',
            $name,
            PHP_EOL
        );
    } catch (Throwable $e) {
        echo $e->getMessage();
        echo PHP_EOL;
        die();
    }
}

function removeMigrationInfo(PDO $pdo, string $key): void
{
    $sql = sprintf(
        'DELETE FROM `db`.`migrations` WHERE `key` = \'%s\';',
        $key,
    );

    $pdo->prepare($sql)->execute();
}

function run(array $migrationsList, array $keys): void
{
    $last = array_key_last($keys);

    if ($migrationsList === []) {
        echo 'All is up to date';
        echo PHP_EOL;
        return;
    }

    $pdo = DBConnector::getInstance()->getConnection();

    try {
        for ($i = 0; $i <= $last; $i++) {
            $key = $keys[$i];
            $fullPath = $migrationsList[$key];
            applyMigration($fullPath, $key, $pdo);
        }
    } catch (Throwable $e) {
        echo $e->getMessage();
        echo PHP_EOL;
        die();
    }
}

$lastMigration = MigrationsUtil::getInstance()->loadLastMigrationFromDB();

if (!is_array($lastMigration)) {
    return;
}

$lastKey = $lastMigration['key'];
$files = array_filter($files, function (string $key) use ($lastKey) {
    return $key <= $lastKey;
}, ARRAY_FILTER_USE_KEY);

$keys = array_keys($files);
rsort($keys);
run($files, $keys);

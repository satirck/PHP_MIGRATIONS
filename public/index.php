<?php

declare(strict_types=1);

use App\DB\Migrations\AbstractMigration;
use App\DB\Migrations\Table\Field\FieldDuplicationException;
use App\DB\Migrations\Table\Table;

include '../vendor/autoload.php';

$testTable = new Table('db', 'test');

try {
    $testTable->addField('id', 'INT', false);
    $testTable->addField('name', 'varchar(20)', false);
    $testTable->addField('email', 'varchar(20)', false);
}catch (FieldDuplicationException $exception){
    echo $exception->getMessage();
}

$anonMigration = new class($testTable) extends AbstractMigration
{
};

$anonMigration->down();

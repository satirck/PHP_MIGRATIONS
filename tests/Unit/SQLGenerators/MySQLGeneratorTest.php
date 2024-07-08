<?php

declare(strict_types=1);

namespace App\Tests\Unit\SQLGenerators;

use App\DB\Migrations\Field;
use App\DB\SQLGenerator\DBQueryGeneratorInterface;
use App\DB\SQLGenerator\MySQLQueryGenerator;
use PHPUnit\Framework\TestCase;

class MySQLGeneratorTest extends TestCase
{
    private DBQueryGeneratorInterface $queryGenerator;

    protected function setUp(): void
    {
        $this->queryGenerator = new MySQLQueryGenerator();
    }

    public function testNotNUllFieldSQLGenerator(): void
    {
        $field = new Field('id', 'int', false);

        $exp = '`id` int NOT NULL';
        $this->assertEquals(
            $exp,
            $this->queryGenerator->getFieldSql($field)
        );
    }

    public function testNullFieldSQLGenerator(): void
    {
        $field = new Field('id', 'int');

        $exp = '`id` int';
        $this->assertEquals(
            $exp,
            $this->queryGenerator->getFieldSql($field)
        );
    }

    public function testOneNotNullFieldTableCreateSQLGenerator(): void
    {
        $field = new Field('id', 'int', false);
        $real = $this->queryGenerator->createTable('db', 'test', [$field]);
        $exp = 'CREATE TABLE IF NOT EXISTS `db`.`test`(`id` int NOT NULL);';

        $this->assertEquals(
            $exp,
            $real
        );
    }

    public function testOneNullFieldTableCreateSQLGenerator(): void
    {
        $field = new Field('name', 'varchar(20)');
        $real = $this->queryGenerator->createTable('db', 'test', [$field]);
        $exp = 'CREATE TABLE IF NOT EXISTS `db`.`test`(`name` varchar(20));';

        $this->assertEquals(
            $exp,
            $real
        );
    }

    public function testFieldsTableCreateSQLGenerator(): void
    {
        $fields = [
            new Field('id', 'int', false),
            new Field('name', 'varchar(20)'),
            new Field('email', 'varchar(20)'),
        ];

        $exp = sprintf(
            '%s(%s);',
            'CREATE TABLE IF NOT EXISTS `db`.`test`',
            '`id` int NOT NULL, `name` varchar(20), `email` varchar(20)'
        );

        $this->assertEquals(
            $exp,
            $this->queryGenerator->createTable('db', 'test', $fields)
        );
    }
}
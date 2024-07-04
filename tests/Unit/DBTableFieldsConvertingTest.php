<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\DB\Migrations\Table\Field\FieldDuplicationException;
use App\DB\Migrations\Table\Field\FieldSqlConvertorInterface;
use App\DB\Migrations\Table\Field\MySqlFieldConvertor;
use App\DB\Migrations\Table\Table;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DBTableFieldsConvertingTest extends TestCase
{
    protected FieldSqlConvertorInterface $convertor;

    /**
     * @return void
     * @before
     */
    protected function setUp(): void
    {
        $this->convertor = new MySqlFieldConvertor();
    }

    /**
     * @throws FieldDuplicationException
     */
    #[Test]
    public function testFieldsConverting(): void
    {
        $table = new Table('test', 'test');

        $table->addField('u_id', 'int', false);
        $table->addField('u_name', 'varchar(20)', false);
        $table->addField('u_status', 'varchar(20)');

        $exp = '`u_id` int NOT NULL, `u_name` varchar(20) NOT NULL, `u_status` varchar(20) ';
        $realFieldQuery = $table->getFieldsQuery();
        $this->assertEquals(
            $exp,
            $realFieldQuery
        );
    }

    #[Test]
    public function testEmptyFieldsConverting(): void
    {
        $table = new Table('test', 'test');

        $this->assertEquals(
            '',
            $table->getFieldsQuery()
        );
    }

    #[Test]
    public function testDuplicateNameException(): void
    {
        $this->expectException(FieldDuplicationException::class);

        $table = new Table('test', 'test');
        $table->addField('u_id', 'int', false);
        $table->addField('u_id', 'int', false);

    }
}

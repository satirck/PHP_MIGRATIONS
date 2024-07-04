<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\DB\Field;
use App\DB\FieldSqlConvertorInterface;
use App\DB\MySqlFieldConvertor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DBFieldTest extends TestCase
{
    protected FieldSqlConvertorInterface $convertor;

    /**
     * @return void
     * @before
     */
    protected function setUp(): void{
        $this->convertor = new MySqlFieldConvertor();
    }

    #[Test]
    public function testFieldConversion(): void
    {
        $field = new Field('id', 'int', false);

        $sqlString = $this->convertor->convert($field);

        $this->assertEquals(
            '`id` int NOT NULL, ',
            $sqlString,
            sprintf(
                'Not expected one expression. [%s] is received',
                $sqlString
            )
        );
    }
}

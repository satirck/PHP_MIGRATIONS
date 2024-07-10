<?php

declare(strict_types=1);

namespace App\Migrations\Files;

use App\DB\Migrations\Migration;

return new class() extends Migration {
    public function up(): void
    {
        $table = $this->table;
        $table->create('db', 'users');
        $table->setColumn('id', 'int', false);
        $table->setColumn('name', 'varchar(20)', false);
        $table->setColumn('age', 'int', false);
        $table->setColumn('email', 'varchar(20)', false);
    }

    public function down(): void
    {
        $table = $this->table;
        $table->remove('db', 'users');
    }
};
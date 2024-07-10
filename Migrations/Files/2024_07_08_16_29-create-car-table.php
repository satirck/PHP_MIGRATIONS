<?php

declare(strict_types=1);

namespace App\Migrations\Files;

use App\DB\Migrations\Migration;

return new class extends Migration{
    public function up(): void{
        $table = $this->table;
        $table->create('db', 'car');
        $table->setColumn('id', 'int', false);
        $table->setColumn('model', 'varchar(50)', false);
        $table->setColumn('year', 'int', false);
    }

    public function down(): void{
        $table = $this->table;
        $table->remove('db', 'car');
    }
};
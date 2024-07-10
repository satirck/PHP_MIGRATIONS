<?php

declare(strict_types=1);

namespace App\Migrations\Files;

use App\DB\Migrations\Migration;

return new class() extends Migration {
    public function up(): void
    {
        $table = $this->table;
        $table->update('db', 'car');
        $table->setColumn('user_id', 'int', false);
    }

    public function down(): void
    {
        $table = $this->table;
        $table->update('db', 'car');
        $table->removeColumn('user_id');
    }
};
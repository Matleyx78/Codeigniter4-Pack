@php

declare(strict_types=1);

namespace CodeIgniter\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;

class CreateXXXXTables extends Migration
{
    /**
     * Table name
     */
    private $table = XXXXX;

    public function up(): void
    {

		{! modeljoin !}

	}
    // --------------------------------------------------------------------

    public function down(): void
    {
        $this->db->disableForeignKeyChecks();

		{! modeljoin !}

        $this->db->enableForeignKeyChecks();
    }

    private function createTable(string $tableName): void
    {
        $this->forge->createTable($tableName, false, $this->attributes);
    }
}
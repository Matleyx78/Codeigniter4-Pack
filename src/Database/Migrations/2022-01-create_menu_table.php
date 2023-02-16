<?php

declare(strict_types=1);

namespace Matleyx\CI4P\Controllers;

use CodeIgniter\Database\Migration;

class CreateMenuTables extends Migration
{
    private $prefix_table = 'menu_';
    private $tab_item = array('tname' => 'items', 'pr' => 'meit', );
    private $tab_group = array('tname' => 'groups', 'pr' => 'megr', );

    public function up(): void
    {
        // group
        $this->forge->addField([
            'id_' . $this->tab_group['pr'] => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            $this->tab_group['pr'] . '_description' => ['type' => 'varchar', 'constraint' => 150],
            $this->tab_group['pr'] . '_created_at' => ['type' => 'datetime', 'null' => true],
            $this->tab_group['pr'] . '_updated_at' => ['type' => 'datetime', 'null' => true],
            $this->tab_group['pr'] . '_deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_' . $this->tab_group['pr']);
        $this->forge->createTable($this->prefix_table . '' . $this->tab_group['tname']);

        // item
        $this->forge->addField([
            'id_' . $this->tab_item['pr'] => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            $this->tab_item['pr'] . '_text' => ['type' => 'varchar', 'constraint' => 150],
            $this->tab_item['pr'] . '_url' => ['type' => 'varchar', 'constraint' => 150],
            $this->tab_item['pr'] . '_id_' . $this->tab_group['pr'] => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            $this->tab_item['pr'] . '_position' => ['type' => 'int', 'constraint' => 11,'unsigned' => true,],
            $this->tab_item['pr'] . '_id_parent' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            $this->tab_item['pr'] . '_created_at' => ['type' => 'datetime', 'null' => true],
            $this->tab_item['pr'] . '_updated_at' => ['type' => 'datetime', 'null' => true],
            $this->tab_item['pr'] . '_deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_' . $this->tab_item['pr']);
        $this->forge->addKey($this->tab_item['pr'] . '_id_' . $this->tab_group['pr']);
        $this->forge->addForeignKey($this->tab_item['pr'] . '_id_' . $this->tab_group['pr'], $this->prefix_table . '' . $this->tab_group['tname'], 'id_' . $this->tab_group['pr'], '', 'CASCADE');
        $this->forge->createTable($this->prefix_table . '' . $this->tab_item['tname']);

    }

    // --------------------------------------------------------------------

    public function down(): void
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable($this->prefix_table . '' . $this->tab_item['tname'], true);
        $this->forge->dropTable($this->prefix_table . '' . $this->tab_group['tname'], true);

        $this->db->enableForeignKeyChecks();
    }
}
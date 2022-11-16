<?php

declare(strict_types=1);

namespace Matleyx\CI4P\Controllers;

use CodeIgniter\Database\Migration;

class CreateTestTables extends Migration
{
    private $prefix_table = 'cmms_';
    private $tab_buildings_name = array('tname' => 'worksite', 'pr' => 'wosi',);
    private $tab_sectors_name = array('tname' => 'impianti', 'pr' => 'impi',);
    private $tab_assets_name = array('tname' => 'macchine', 'pr' => 'macc',);

    public function up(): void
    {

        //$prefix_table = 'cmms_';
        //$tab_buildings_name = array('tname' => 'worksite', 'pr' => 'wosi',);
        //$tab_sectors_name = array('tname' => 'impianti', 'pr' => 'impi',);
        //$tab_assets_name = array('tname' => 'macchine', 'pr' => 'macc',);
        $tab_immediate_jobs_name = array('tname' => 'interventi_immediati', 'pr' => 'imjo',);
        $tab_scheduled_jobs_name = array('tname' => 'interventi_programmati', 'pr' => 'scjo',);
        $tab_executed_jobs_name = array('tname' => 'interventi_eseguiti', 'pr' => 'exjo',);


        // Buildings
        $this->forge->addField([
            'id_' . $this->tab_buildings_name['pr']             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            $this->tab_buildings_name['pr'] . '_description'    => ['type' => 'varchar', 'constraint' => 150],
            $this->tab_buildings_name['pr'] . '_created_at'     => ['type' => 'datetime', 'null' => true],
            $this->tab_buildings_name['pr'] . '_updated_at'     => ['type' => 'datetime', 'null' => true],
            $this->tab_buildings_name['pr'] . '_deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_' . $this->tab_buildings_name['pr']);
        $this->forge->createTable($this->prefix_table . '' . $this->tab_buildings_name['tname']);

        // Sectors
        $this->forge->addField([
            'id_' . $this->tab_sectors_name['pr']           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            $this->tab_sectors_name['pr'] . '_description'         => ['type' => 'varchar', 'constraint' => 150],
            $this->tab_sectors_name['pr'] . '_id_' . $this->tab_buildings_name['pr']         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            $this->tab_sectors_name['pr'] . '_created_at'     => ['type' => 'datetime', 'null' => true],
            $this->tab_sectors_name['pr'] . '_updated_at'     => ['type' => 'datetime', 'null' => true],
            $this->tab_sectors_name['pr'] . '_deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_' . $this->tab_sectors_name['pr']);
        $this->forge->addKey($this->tab_sectors_name['pr'] . '_id_' . $this->tab_buildings_name['pr']);
        $this->forge->addForeignKey($this->tab_sectors_name['pr'] . '_id_' . $this->tab_buildings_name['pr'], $this->prefix_table . '' . $this->tab_buildings_name['tname'], 'id_' . $this->tab_buildings_name['pr'], '', 'CASCADE');
        $this->forge->createTable($this->prefix_table . '' . $this->tab_sectors_name['tname']);

        // Assets
        $this->forge->addField([
            'id_' . $this->tab_assets_name['pr']           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            $this->tab_assets_name['pr'] . '_description'         => ['type' => 'varchar', 'constraint' => 150],
            $this->tab_assets_name['pr'] . '_id_' . $this->tab_sectors_name['pr']         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            $this->tab_assets_name['pr'] . '_created_at'     => ['type' => 'datetime', 'null' => true],
            $this->tab_assets_name['pr'] . '_updated_at'     => ['type' => 'datetime', 'null' => true],
            $this->tab_assets_name['pr'] . '_deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_' . $this->tab_assets_name['pr']);
        $this->forge->addKey($this->tab_assets_name['pr'] . '_id_' . $this->tab_sectors_name['pr']);
        $this->forge->addForeignKey($this->tab_assets_name['pr'] . '_id_' . $this->tab_sectors_name['pr'], $this->prefix_table . '' . $this->tab_sectors_name['tname'], 'id_' . $this->tab_sectors_name['pr'], '', 'CASCADE');
        $this->forge->createTable($this->prefix_table . '' . $this->tab_assets_name['tname']);

    }

    // --------------------------------------------------------------------

    public function down(): void
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable($this->prefix_table . '' . $this->tab_assets_name['tname'], true);
        $this->forge->dropTable($this->prefix_table . '' . $this->tab_buildings_name['tname'], true);
        $this->forge->dropTable($this->prefix_table . '' . $this->tab_sectors_name['tname'], true);
        $this->forge->dropTable('auth_identities', true);
        $this->forge->dropTable('auth_groups_users', true);
        $this->forge->dropTable('auth_permissions_users', true);
        $this->forge->dropTable('users', true);

        $this->db->enableForeignKeyChecks();
    }
}

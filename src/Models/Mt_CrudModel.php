<?php

namespace Matleyx\CI4P\Models;

use CodeIgniter\Model;

class Mt_CrudModel extends Model
{
    protected $db;

    public function __construct()
        {
        $this->db = db_connect();
        }

    public function getAllTables()
        {

        $tables = $this->db->listTables();
        return $tables;
        }

    public function getAllFields($table)
        {
        $fields = $this->db->getFieldData($table);
        return $fields;
        }

    public function getAllIndex($table)
        {
        $indx = $this->db->getIndexData($table);
        return $indx;
        }

    public function getAllFK($table)
        {
        $foreikeys = $this->db->getForeignKeyData($table);
        return $foreikeys;
        }

}
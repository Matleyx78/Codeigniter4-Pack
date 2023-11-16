<?php

namespace Matleyx\CI4P\Models;

use CodeIgniter\Model;

class Mt_GeneratorModel extends Model
{
    protected $db;
	//protected $dba;

    public function __construct()
        {
        $this->db = db_connect();
		//$this->dba = \Config\Database::connect('adhoc');
        }

    public function geta()
        {

        $ris = $this->db->listTables();
        return $ris;
        }

	public function getadhoc()
	{

		$ris = $this->dba->listTables();
		return $ris;
	}

    public function getb()
        {
        $ris = $this->db->getFieldData('users_groups');
        return $ris;
        }

    public function getc()
        {
        $ris = $this->db->getIndexData('users_groups');
        return $ris;
        }

    public function getd()
        {
        $ris = $this->db->getForeignKeyData('users_groups');
        return $ris;
        }
}
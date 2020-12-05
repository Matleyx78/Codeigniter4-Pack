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

	public function geta()
	{

		$ris = $this->db->listTables();
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
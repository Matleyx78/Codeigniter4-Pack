@php
namespace {namespace}\Models;

use CodeIgniter\Model;

class {! nameModel !} extends Model
{
protected $DBGroup = 'default';
protected $table = '{! table !}';
protected $primaryKey = '{! primaryKey !}';
protected $useAutoIncrement = true;
//protected $insertID = 0;
protected $returnType = 'array';
protected $useSoftDeletes = true;
protected $protectFields = true;
protected $allowedFields = [
{! allowedFields !}
];

// Dates
protected $useTimestamps = true;
protected $dateFormat = 'datetime';
protected $createdField = '{! pk_string !}_created_at';
protected $updatedField = '{! pk_string !}_updated_at';
protected $deletedField = '{! pk_string !}_deleted_at';

// Validation
protected $validationRules = [
{! fieldsVal !}
];
protected $validationMessages = [];
protected $skipValidation = false;
protected $cleanValidationRules = true;

// Callbacks
protected $allowCallbacks = false;
protected $beforeInsert = [];
protected $afterInsert = [];
protected $beforeUpdate = [];
protected $afterUpdate = [];
protected $beforeFind = [];
protected $afterFind = [];
protected $beforeDelete = [];
protected $afterDelete = [];

{! optionBox !}
{! modeljoin !}
}
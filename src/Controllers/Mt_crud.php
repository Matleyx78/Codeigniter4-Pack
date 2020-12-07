<?php

namespace Matleyx\CI4P\Controllers;

use App\Controllers\BaseController;
use Matleyx\CI4P\Models\Mt_CrudModel;
use PhpZip\ZipFile;

class Mt_crud extends BaseController
{

	public function index()
	{
		helper('form');
		$model          = new Mt_CrudModel();
		$table='cartellini_produzione';
		$data['result'] = $model->getAllTables();
		$data['fields'] = $array          = json_decode(json_encode($model->getAllFields($table)), true);
		$data['keys']   = $array          = json_decode(json_encode($model->getAllIndex($table)), true);
		$fork           = $model->getAllFK($table);
		$data['fork']   = $array          = json_decode(json_encode($fork), true);
		return view('Matleyx\CI4P\Views\crud\crud', $data);
	}

	public function crudgen()
	{
		if ($this->request->getMethod() === 'post')
		{
			$incoming['tname']     = $this->request->getPost('tname');
			$incoming['cname']     = $this->request->getPost('cname');
			$incoming['fname']     = $this->request->getPost('fname');
			$incoming['obsofield'] = $this->request->getPost('obsofield');
			$incoming['funz']      = $this->build_model($incoming['cname']);
			$nomefile              = 'provanomefile.php';
			$zipFile               = new \PhpZip\ZipFile();
			try
			{
				$zipFile
				->addFromString($nomefile, $incoming['funz']) // add an entry from the string
				->outputAsAttachment($incoming['tname'] . '.zip'); // output to the browser without saving to a file
			}
			catch (\PhpZip\Exception\ZipException $e)
			{
				// handle exception
			}
			finally
			{
				$zipFile->close();
			}
		}
		else
		{
			return redirect()->route('mt_crud');
		}
	}

	protected function build_model()
	{
		$file_a = '<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = \'users\';
    protected $primaryKey = \'id\';

    protected $returnType     = \'array\';
    protected $useSoftDeletes = true;

    protected $allowedFields = [\'name\', \'email\'];

    protected $useTimestamps = false;
    protected $createdField  = \'created_at\';
    protected $updatedField  = \'updated_at\';
    protected $deletedField  = \'deleted_at\';

	protected $validationRules    = [
			\'username\'     => \'required|alpha_numeric_space|min_length[3]\',
			\'email\'        => \'required|valid_email|is_unique[users.email]\',
			\'password\'     => \'required|min_length[8]\',
			\'pass_confirm\' => \'required_with[password]|matches[password]\'
		];
		
	protected $validationMessages = [
		\'email\'        => [
			\'is_unique\' => \'Sorry. That email has already been taken. Please choose another.\'
			]
		];
		
	protected $skipValidation     = false;
}';
		return $file_a;
	}
}
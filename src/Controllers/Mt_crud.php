<?php

namespace Matleyx\CI4P\Controllers;

use App\Controllers\BaseController;
use Matleyx\CI4P\Models\Mt_CrudModel;
use PhpZip\ZipFile;

class Mt_crud extends BaseController
    {

    protected $model;
    protected $table_name;
    protected $primary_key;
    protected $controller_name;
    protected $record_name;
    protected $softdeleted_enable;
    protected $timestamp_enable;
    protected $returntype;

    public function __construct()
        {
        helper('form');
        $this->model = new Mt_CrudModel();
        }

    public function index()
        {
        helper('form');
        //$model          = new CrudtestModel();
        $table          = 'cartellini_produzione';
        $data['result'] = $this->model->getAllTables();
        return view('Matleyx\CI4P\Views\crud\crud', $data);
        }

    public function crudgen()
        {
        if ( $this->request->getMethod() === 'post' )
            {
            $incoming['tname']     = $this->request->getPost('tname');
            $incoming['cname']     = $this->request->getPost('cname');
            $incoming['fname']     = $this->request->getPost('fname');
            $incoming['obsofield'] = $this->request->getPost('obsofield');
            $incoming['fields']    = $this->model->getAllFields($incoming['tname']);
            $incoming['prk']       = $this->model->getAllIndex($incoming['tname']);
            $incoming['fk']        = $this->model->getAllFK($incoming['tname']);

            $data = $incoming;

            return view('Matleyx\CI4P\Views\crud\viewtable', $data);

//			$incoming['funz']      = $this->build_model($incoming['cname']);
//			$nomefile              = 'provanomefile.php';
//			$zipFile               = new \PhpZip\ZipFile();
//			try
//			{
//				$zipFile
//				->addFromString($nomefile, $incoming['funz']) // add an entry from the string
//				->outputAsAttachment($incoming['tname'] . '.zip'); // output to the browser without saving to a file
//			}
//			catch (\PhpZip\Exception\ZipException $e)
//			{
//				// handle exception
//			}
//			finally
//			{
//				$zipFile->close();
//			}
            }
        else
            {
            return redirect()->route('mt_crud');
            }
        }

    public function test()
        {
        if ( $this->request->getMethod() === 'post' )
            {
            $incoming['tname']     = $this->request->getPost('tname');
            $incoming['cname']     = $this->request->getPost('cname');
            $incoming['fname']     = $this->request->getPost('fname');
            $incoming['obsofield'] = $this->request->getPost('obsofield');
            $incoming['fields']    = $this->model->getAllFields($incoming['tname']);
            $incoming['prk']       = $this->model->getAllIndex($incoming['tname']);
            $incoming['fk']        = $this->model->getAllFK($incoming['tname']);

            $data = $incoming;

            return view('Matleyx\CI4P\Views\crud\viewtable', $data);

//			$incoming['funz']      = $this->build_model($incoming['cname']);
//			$nomefile              = 'provanomefile.php';
//			$zipFile               = new \PhpZip\ZipFile();
//			try
//			{
//				$zipFile
//				->addFromString($nomefile, $incoming['funz']) // add an entry from the string
//				->outputAsAttachment($incoming['tname'] . '.zip'); // output to the browser without saving to a file
//			}
//			catch (\PhpZip\Exception\ZipException $e)
//			{
//				// handle exception
//			}
//			finally
//			{
//				$zipFile->close();
//			}
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

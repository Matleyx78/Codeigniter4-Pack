<?php

namespace Matleyx\CI4P\Controllers;

use App\Controllers\BaseController;
use Matleyx\CI4P\Models\Mt_CrudModel;

class Mt_crud extends BaseController
{

	public function index()
	{
		helper('form');
		$model          = new Mt_CrudModel();
		$data['result']    = $model->geta();
		$data['fields'] = $array          = json_decode(json_encode($model->getb()), true);
		$data['keys']   = $array          = json_decode(json_encode($model->getc()), true);
		$fork           = $model->getd();
		$data['fork']   = $array          = json_decode(json_encode($fork), true);
		return view('Matleyx\CI4P\Views\crud\crud', $data);
	}

	public function crudgen()
	{
		if ($this->request->getPost())
		{

			$tab = $this->request->getPost('tname').'1';
			$tab2 = $this->request->getPost('tablename').'a';


			echo $tab;
			echo $tab2;

		}
		else
		{
			echo 'nulla';}
	}
}
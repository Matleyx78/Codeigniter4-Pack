<?php

namespace Matleyx\CI4P\Controllers;

use App\Controllers\BaseController;
use Matleyx\CI4P\Models\Mt_CrudModel;

class Mt_crud extends BaseController
{

    //use \CodeIgniter\API\ResponseTrait;

    public function index()
        {
        $model          = new Mt_CrudModel();
        $data['tab']    = $model->geta();
        $data['fields'] = $array          = json_decode(json_encode($model->getb()), true);
        $data['keys']   = $array          = json_decode(json_encode($model->getc()), true);
        $fork           = $model->getd();
        $data['fork']   = $array          = json_decode(json_encode($fork), true);
        return view('Matleyx\CI4P\Views\crud\crud', $data);
        }

}
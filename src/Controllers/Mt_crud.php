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
        $data['result'] = $model->geta();
        $data['fields'] = $array          = json_decode(json_encode($model->getb()), true);
        $data['keys']   = $array          = json_decode(json_encode($model->getc()), true);
        $fork           = $model->getd();
        $data['fork']   = $array          = json_decode(json_encode($fork), true);
        return view('Matleyx\CI4P\Views\crud\crud', $data);
        }

    public function Acrudgen()
        {
        $zip      = new ZipArchive;
        $tmp_file = '../writable/myzip.zip';
        if ($zip->open($tmp_file, ZipArchive::CREATE))
            {
            $zip->addFile('folder/ff.txt', 'robot.txt');
            $zip->close();
            echo 'Archive created!';
            header('Content-disposition: attachment; filename=myzip.zip');
            header('Content-type: application/zip');
            readfile($tmp_file);
            }
        else
            {
            echo 'Failed!';
            }

        //		if ($this->request->getMethod() === 'post')
        //		{
        //			$nome = 'prova.txt';
        //			$incoming['tname'] = $this->request->getPost('tname');
        //			$incoming['cname'] = $this->request->getPost('cname');
        //			$incoming['fname'] = $this->request->getPost('fname');
        //			$incoming['obsofield'] = $this->request->getPost('obsofield');
        //			$incoming['funz'] = $this->buildfile($incoming['tname']);
        //			echo '<pre>';
        //			print_r($incoming);
        //			echo '</pre>';
        //		}
        //		else
        //		{
        //			echo 'nulla';}
        }

    public function buildfile($add)
        {
        $file_a = 'slajdslakdjslk ' . $add;
        return $file_a;
        }

    public function crudgen()
        {

        $projectName = 'Project';

        $projectDirectory = ROOTPATH . 'writable';

        $zipComments = 'Some Comments';

        $zipFile = new \PhpZip\ZipFile();

        try
            {

            $zipFile
                    ->addDirRecursive($projectDirectory)
                    ->setArchiveComment($zipComments)
                    ->setPassword('12345') // set password for all entries
                    ->outputAsAttachment('filename.zip'); // outpudt to the browser without saving to a file
            } catch (\PhpZip\Exception\ZipException $e)
            {
            // handle exception
            }
        }

}
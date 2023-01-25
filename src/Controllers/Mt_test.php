<?php

namespace Matleyx\CI4P\Controllers;

use App\Controllers\BaseController;
use Matleyx\CI4P\Models\Mt_TestModel;
use Matleyx\CI4P\Libraries\Calendario;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;

class Mt_test extends BaseController
{

    // available to GET requests only
    public function index()
    {
        helper('date');

        $cal = new Calendario();
        $giorno = '2021-03-15 00:00:00';
        $data['giorno1'] = now();
        $data['mysql'] = $cal->primo_del_mese($giorno);
        //var_dump($data['mysql']);
        //$data['ris2']    = mysql_to_human1($data['mysql']);

        return view('Matleyx\CI4P\Views\test\testview', $data);
    }

    public function adhoc()
    {
        helper('date');
        $model = new Mt_TestModel();
        $data['result'] = $model->getadhoc();

        return view('Matleyx\CI4P\Views\test\testview', $data);
    }

    public function mt_exc()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $fileName = 'data.xlsx';
        ob_clean();
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
        exit();
    }

    public function tedata($fr = '')
    {
        if (!isset($fr))
        {
            $fr = '78';
        }
        $data['ris'] = $fr;

        return view('Matleyx\CI4P\Views\test\testview', $data);
    }

}
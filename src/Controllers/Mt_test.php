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
        $test = true;
        //if ( $this->ionAuth->loggedIn() )
        
        if ( $test )
            {
            $data['ris'] = 'si';
            }
        else
            {
            $data['ris'] = 'no';
            }
        $data['giorno1'] = now();
        $data['mysql']   = $cal->primo_del_mese();
        $data['ris2']    = mysql_to_human1($data['mysql']);

        return view('Matleyx\CI4P\Views\test\testview', $data);
        }

    public function adhoc()
        {
        helper('date');
        $model = new Mt_TestModel();
        //$data['result'] = $model->getadhoc();

        return view('Matleyx\CI4P\Views\test\testview', $data);
        }

    public function mt_exc()
        {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $fileName    = 'data.xlsx';
        $writer      = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
        }

    public function mt_pdf()
        {
        try
            {
            $mpdf = new \Mpdf\Mpdf();

            $mpdf->debug = true;
            $mpdf->WriteHTML('Hello World');
            //ob_end_clean();
            //return $mpdf->Output('filename.pdf', 'I');
            return redirect()->to($mpdf->Output('filename.pdf', 'I'));
            } catch (\Mpdf\MpdfException $e)
            {
            // Note: safer fully qualified exception name used for catch
            // Process the exception, log, print etc.
            echo $e->getMessage();
            }
        }

    public function tedata($fr = '')
        {
        if (! isset($fr) )
            {
            $fr = '78';
            }
        $data['ris'] = $fr;

        return view('Matleyx\CI4P\Views\test\testview', $data);
        }

    }

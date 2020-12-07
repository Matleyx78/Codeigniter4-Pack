<?php

namespace Matleyx\CI4P\Controllers;

use App\Controllers\BaseController;
use Matleyx\CI4P\Libraries\Calendario;

class Mt_test extends BaseController
{
    // available to GET requests only
    public function index()
    {
		helper('date');
		$cal = new Calendario();
		if ( $this->ionAuth->loggedIn() )
			{
				$data['ris'] = 'si';
			}
			else
			{
				$data['ris'] = 'no';}
		$data['giorno1'] = now();
		$data['mysql'] = $cal->primo_del_mese();
		$data['ris2'] = mysql_to_human1($data['mysql']);
		
        return view('Matleyx\CI4P\Views\test\testview',$data);
    }
} 

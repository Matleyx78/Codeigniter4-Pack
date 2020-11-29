<?php
namespace Matleyx\CI4P\Libraries;

class Calendario
{
    function primo_del_mese()
	      {
                    $now = time();
                    $mm = date("m",$now);
                    $yyyy = date("Y",$now);
                    
                    $primo = $yyyy."-".$mm."-01";

		        return $primo;
	      }
}

<?php

function array_msort($array, $cols)
// $array = array da ordinare,$cols = colonna secondo cui ordinare Es. array_msort($data['dipendenti'], array('ass1'=>SORT_DESC));
//ORDINAMENTO DI UN ARRAY PER COLONNA vedi:https://blog.mrwebmaster.it/2011/03/11/ordinare-un-array-multi-dimensionale-in-php.html
//      esempio
//$utenti = array( 
//    array('id'=>1, 'nome'=>'Mario', 'cognome'=>'Rossi'), 
//    array('id'=>2, 'nome'=>'Paolo', 'cognome'=>'Bianchi'), 
//    array('id'=>3, 'nome'=>'Luca', 'cognome'=>'Neri'), 
//    array('id'=>4, 'nome'=>'Clauidia', 'cognome'=>'Bianchi'), 
//); 
//$utenti = array_msort($utenti, array('cognome'=>SORT_ASC, 'nome'=>SORT_ASC)); 
    {
    $colarr = array();
    foreach ($cols as $col => $order)
        {
        $colarr[$col] = array();
        foreach ($array as $k => $row)
            {
            $colarr[$col]['_' . $k] = strtolower($row[$col]);
        }
        }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order)
        {
        $eval .= '$colarr[\'' . $col . '\'],' . $order . ',';
        }
    $eval = substr($eval, 0, -1) . ');';
    eval($eval);
    $ret  = array();
    foreach ($colarr as $col => $arr)
        {
        foreach ($arr as $k => $v)
            {
            $k             = substr($k, 1);
            if ( !isset($ret[$k]) )
                $ret[$k]       = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
            }
        }
    return $ret;
    }

function unique_multidim_array($array, $key)//unique_multidim_array
    {
    $temp_array = array();
    $i          = 0;
    $key_array  = array();

    foreach ($array as $val)
        {
        if ( !in_array($val[$key], $key_array) )
            {
            $key_array[$i]  = $val[$key];
            $temp_array[$i] = $val;
            }
        $i++;
        }
    return $temp_array;
    }

function o_t_a($object)//object to array
    {
    $array = json_decode(json_encode($object), true);
    return $array;
    }
function trim_all_multidim_array($array)//trim_multidim_array
        {
    $temp_array = array();
   
    foreach($array as $key1=>$val1)
        {
            foreach ($val1 as $key2=>$val2)
                {
                    $temp_array[$key1][$key2] = trim($val2);
                }
        }
    return $temp_array;
}
    function array_to_csv($array, $attachment = false, $headers = true, $filename = '') {
               $now = date("Y-m-d_H-i-s");
        if ($filename === '')
            {
                $filename = 'AutoNameCsvFromArray';
            }
        $filename = $filename."_".$now.".csv";
        
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen('php://output', 'w');
        } else {
            $fp = fopen($filename, 'w');
        }
       
        $result = $array;
       
        if($headers) {
            // output header row (if at least one row exists)
            $row = $result[0];
            if($row) {
                fputcsv($fp, array_keys($row),';');
                // reset pointer back to beginning
                //mysql_data_seek($result, 0);
            }
        }
       foreach ($result as $row)
            {
                fputcsv($fp, $row,';');
            }
//        while($row = mysql_fetch_assoc($result)) {
//            fputcsv($fp, $row);
//        }
       
        fclose($fp);
    }

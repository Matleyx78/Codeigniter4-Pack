<?php
function string_purifier($string = '')
{
    $string = str_replace(['à', 'á','â','å','ã','ä',], 'a', $string);
    $string = str_replace(['è', 'é','ê','ë',], 'e', $string);
    $string = str_replace(['ì', 'í','î','ï',], 'i', $string);
    $string = str_replace(['ò', 'ó','ô','ø','õ','ö',], 'o', $string);
    $string = str_replace(['ù', 'ú','û','ü',], 'u', $string);

    $string = str_replace(['Á', 'À','Â', 'Å','Ã','Ä'], 'A', $string);
    $string = str_replace(['É', 'È','Ê','Ë',], 'E', $string);
    $string = str_replace(['Í', 'Ì','Î','Ï',], 'I', $string);
    $string = str_replace(['Ó', 'Ò','Ô','Ø','Õ','Ö',], 'O', $string);
    $string = str_replace(['Ú', 'Ù','Û','Ü',], 'U', $string);

    $string = str_replace('æ', 'ae', $string);
    $string = str_replace('Æ', 'AE', $string);
    $string = str_replace('ç', 'c', $string);
    $string = str_replace('Ç', 'C', $string);
    $string = str_replace('ñ', 'n', $string);
    $string = str_replace('Ñ', 'N', $string);

    $string = str_replace('/', '-', $string);
    $string_trim = trim($string);
    $multispace = preg_replace('/\s+/',' ',$string_trim);  //multispce
    $under = str_replace(' ', '_', $multispace);
    $purified = preg_replace('/[^0-9a-zA-Z_-]/', '', $under);
    return $purified;
}

function string_generator($lenght = '')
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = ''; 
    for ($i = 0; $i < $lenght; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
 
    return $randomString;
}

function code_and_desc($string)
{
    $esplosi = explode(' ', $string);
    $final_code = '';
    foreach ($esplosi as $es)
    {
        $str = substr($es, 0, 2);
        $final_code .= $str;
    }
    $dati['c'] = string_purifier($final_code).string_generator(3);
    $dati['d'] = string_purifier($string);

    return $dati;
}
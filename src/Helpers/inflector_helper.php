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

    $string_trim = trim($string);
    $multispace = preg_replace('/\s+/', ' ', $string_trim);   //multispce
    $under = str_replace(' ', '_', $multispace);
    $purified = preg_replace('/[a-zA-Z0-9_-]+/', '-', $under);
    return $purified;
}
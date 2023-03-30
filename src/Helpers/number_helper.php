<?php

    public function mod_med_med($lista = array())
    {
        if (!isset($lista) or count($lista) == 0)
        {
            return false;
        }
        //print_r($lista);
        $total_items = count($lista);
        asort($lista);
        foreach ($lista as $o)
        {
            $arr_ord[] = $o;
        }
        $result['max'] = max($lista);
        $result['min'] = min($lista);
        // MEDIA
        $res_media = 0;
        foreach ($lista as $n)
        {
            $res_media += $n;
        }
        $result['media'] = round($res_media / $total_items);
        // FINE MEDIA
        //  MEDIANA
        $middle = ceil($total_items / 2);
        $result['mediana'] = $arr_ord[$middle];
        //FINE MEDIANA
        // MODA        
        $moda = array_count_values($arr_ord);
        $value = max( $moda);
        $key = array_search($value, $moda);
        $result['moda'] = $key;
        //FINE MODA
        //  MEDIA PESATA
        if ($total_items < 5)
            {
                $result['m_p'] = $result['media'];
            }else{
                if ($total_items >= 5 AND $total_items < 15){
                    $row_sub = 1;
                }else{
                    $row_sub = round($total_items / 10);
                }
                array_splice($lista, 0 , $row_sub);     //  TOLGO I PRIMI                
                array_splice($lista, -$row_sub , $row_sub);     //  TOLGO GLI ULTIMI
                $total_items_m_p = count($lista);
                $res_m_p = 0;
                foreach ($lista as $m)
                {
                    $res_m_p += $m;
                }
                $result['m_p'] = round($res_m_p / $total_items_m_p);
            }
        //FINE MEDIA PESATA
            // $result['controllo']['item_inizio'] = $total_items;
            
            // $result['controllo']['item_fine'] = $total_items_m_p;
        return $result;
    }

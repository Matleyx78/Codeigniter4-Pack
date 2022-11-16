<?php

namespace Matleyx\CI4P\Libraries;

use CodeIgniter\I18n\Time;
use Matleyx\CI4P\Config\Ci4CalConfig;

class Calendario
{
    function __construct()
    {
        helper('Matleyx\CI4P\Helpers\date');
    }
    function primo_del_mese($datetime = null)
    {
        $time = new Time();
        //var_dump($datetime);
        if ($datetime == null) {
            $datetime = $time->toDateString();
        }
        $result = $time->parse($datetime); //YYYY-MM-DD
        $result = $result->setDay(01);
        $result = $result->toDateString();

        return $result;
    }

    function buildMonths($monthNum, $yearNum, $easterDay)
    {
        $firstDay = mktime(0, 0, 0, $monthNum, 1, $yearNum);
        $daysPerMonth = intval(date("t", $firstDay));

        for ($i = 1; $i <= $daysPerMonth; $i++) {
            $m[$i] = $this->dayType($monthNum, $i, $yearNum, $easterDay);
        }

        return $m;
    }



    function isHoliday($monthNumber, $dayNumber)
    {
        $monthNumber = intval($monthNumber);
        $dayNumber = intval($dayNumber);
        $holiday = array(
            1 => array(1, 6),
            4 => array(25),
            5 => array(1),
            6 => array(2),
            8 => array(10, 15),
            11 => array(1),
            12 => array(8, 25, 26)
        );
        $holidayKeys = array_keys($holiday);

        if (in_array($monthNumber, $holidayKeys)) {
            if (in_array($dayNumber, $holiday[$monthNumber])) {
                return true;
            }
        }

        return false;
    }

    function isMomentoLavorativo($array, $istante)
    {
        $compreso = FALSE;

        foreach ($array as $a) {
            if ($istante >= $a['I'] && $istante < $a['F']) {
                $compreso = TRUE;
            }
        }

        return $compreso;
    }
    function easterDay($year)
    {
        $e = strtotime("$year-03-21 +" . easter_days($year) . " days");
        $easterDay = array(
            "month" => intval(date("n", $e)),
            "day" => intval(date("j", $e)),
        );

        return $easterDay;
    }



    function isgiornolavorativo($daytime)
    {
        //$timestamp = mysql_to_unix($daytime);
        $timestamp = Time::parse($daytime);
        $timestamp = $timestamp->getTimestamp();
        $anno = date("Y", $timestamp);
        $mese = date("m", $timestamp);
        $giorno = date("d", $timestamp);
        $pasq = $this->easterDay($anno);
        $tipo = $this->dayType($mese, $giorno, $anno, $pasq);
        $lavorativo = FALSE;

        if ($tipo['F'] == "APERTO") {
            $lavorativo = TRUE;
        }

        return $lavorativo;
    }

    function diff_giorni_lavorativi($datavecchia, $datagiovane)
    {
        $giorni = 0;
        $timestampvecchia = Time::parse($datavecchia);
        $timestampvecchia = $timestampvecchia->getTimestamp();
        $timestampgiovane = Time::parse($datagiovane);
        $timestampgiovane = $timestampgiovane->getTimestamp();
        $elencogiorni = array();
        $elencogiorni[] = $datavecchia;

        do {
            $timestampvecchia += 86400;
            $elencogiorni[] = $this->unix_to_human($timestampvecchia, TRUE, 'eu');

            if ($this->isgiornolavorativo($this->unix_to_human($timestampvecchia, TRUE, 'eu'))) {
                $giorni += 1;
            }
        } while ($timestampvecchia < $timestampgiovane);

        return $giorni;
    }




    function dayType($monthNum, $i, $yearNum, $easterDay)
    {
        $giorniSettimana = array("Domenica", "Lunedi", "Martedi", "Mercoledi", "Giovedi", "Venerdi", "Sabato");
        $actualDay = mktime(0, 0, 0, $monthNum, $i, $yearNum);
        $numDay = intval(date("w", $actualDay));

        if (($monthNum == $easterDay['month']) && (intval(date("j", $actualDay)) == $easterDay['day'])) {
            $f = "PASQUA";
        } elseif ($numDay == 0 or $numDay == 6) {
            $f = "CHIUSO";
        } elseif ($this->isHoliday($monthNum, date("j", $actualDay))) {
            $f = "FESTA";
        } elseif ($this->isFerie($yearNum, $monthNum, date("j", $actualDay))) {
            $f = "FERIE AZ.";
        } elseif ($this->isCassa($yearNum, $monthNum, date("j", $actualDay))) {
            $f = "CASSA INT.";
        } elseif (($monthNum == $easterDay['month']) && (intval(date("j", $actualDay)) == $easterDay['day'] + 1)) {
            $f = "PASQUETTA";
        } elseif ((($easterDay['day'] == 31 && $easterDay['month'] == 3 && intval(date("j", $actualDay)) == 1 && $monthNum == 4) || ($easterDay['day'] == 30 && $easterDay['month'] == 4) && intval(date("j", $actualDay)) == 1 && $monthNum == 5)) {
            $f = "PASQUETTA";
        } else {
            $f = "APERTO";
        }

        $i = array(
            "day" => date("d", $actualDay),
            "weekday" => iconv('UTF-8', 'CP1252', $giorniSettimana[$numDay]),
            "F" => $f,
        );

        return $i;
    }





    function isFerie($yearNumber, $monthNumber, $dayNumber)
    {
        $yearNumber = intval($yearNumber);
        $monthNumber = intval($monthNumber);
        $dayNumber = intval($dayNumber);

        $ferie = array(
            2017 => array(
                1 => array(2, 3, 4, 5),
                4 => array(14, 24),
                6 => array(1),
                7 => array(31),
                8 => array(1, 2, 3, 4, 7, 8, 9, 11, 14, 16, 17, 18, 21, 22, 23, 24, 25),
                12 => array(27, 28, 29)
            ),
            2018 => array(
                1 => array(2, 3, 4, 5),
                4 => array(26, 27, 30),
                8 => array(6, 7, 8, 9, 13, 14, 16, 17, 20, 21, 22, 23, 24, 27, 28, 29, 30, 31),
                11 => array(2),
                12 => array(24, 27, 28, 31),
            ),
            2019 => array(
                1 => array(2, 3, 4),
                4 => array(23, 24, 26),
                8 => array(5, 6, 7, 8, 9, 12, 13, 14, 16, 19, 20, 21, 22, 23, 26, 27, 28, 29, 30),
                12 => array(23, 24, 27, 30, 31),
            ),
            2020 => array(
                1 => array(2, 3),
                4 => array(10, 30),
                5 => array(29),
                6 => array(1),
                8 => array(11, 12, 13, 14, 17, 18, 19, 20, 21, 24, 25, 26, 27, 28),
                12 => array(7, 24, 28, 29, 30, 31),
            ),
            2021 => array(
                1 => array(4, 5),
                4 => array(2),
                6 => array(3, 4),
                8 => array(2, 3, 4, 5, 6, 9, 11, 12, 13, 16, 17, 18, 19, 20, 23, 24, 25, 26, 27),
                12 => array(6, 7, 24, 27, 28, 29, 30, 31),
            ),
            2022 => array(
                1 => array(3, 4, 5, 7),
                6 => array(3),
                8 => array(1, 2, 3, 4, 5, 8, 9, 11, 12, 16, 17, 18, 19, 22, 23, 24, 25, 26),
                10 => array(31),
                12 => array(9, 27, 28, 29, 30, 31),
            ),
        );

        $annoKeys = array_keys($ferie);

        if (in_array($yearNumber, $annoKeys)) {
            $meseKeys[$yearNumber] = array_keys($ferie[$yearNumber]);

            if (in_array($monthNumber, $meseKeys[$yearNumber])) {
                if (in_array($dayNumber, $ferie[$yearNumber][$monthNumber])) {
                    return true;
                }
            }

            return false;
        }
    }

    function isCassa($yearNumber, $monthNumber, $dayNumber)
    {
        $yearNumber = intval($yearNumber);
        $monthNumber = intval($monthNumber);
        $dayNumber = intval($dayNumber);

        $cassa = array(
            2020 => array(
                3 => array(23, 24, 25, 26, 27, 30, 31),
                4 => array(1, 2, 3, 6, 7, 8, 9, 14, 15, 16, 17, 20, 21, 22, 23, 24, 27, 28, 29, 30),
            ),
        );

        $annoKeys = array_keys($cassa);

        if (in_array($yearNumber, $annoKeys)) {
            $meseKeys[$yearNumber] = array_keys($cassa[$yearNumber]);

            if (in_array($monthNumber, $meseKeys[$yearNumber])) {
                if (in_array($dayNumber, $cassa[$yearNumber][$monthNumber])) {
                    return true;
                }
            }

            return false;
        }
    }



    function buildList($tipo, $composto = '')
    { // Restituisce in output un array di giorni: anno, mese, giorno, nome mese, nome giorno, tipo
        if ($composto === '') {
            $composto = 0;  //  Se composto è VERO, allora crea array composto
        }

        $mesiAnno = array("GENNAIO", "FEBBRAIO", "MARZO", "APRILE", "MAGGIO", "GIUGNO", "LUGLIO", "AGOSTO", "SETTEMBRE", "OTTOBRE", "NOVEMBRE", "DICEMBRE");

        switch ($tipo) {
            case 1:     //$tipo =   1   Ultimi 15 giorni ORDINE INVERTITO
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $iniziomese, $iniziogiorno - 15, $inizioanno))); //15 giorni prima di oggi
                $reverseinavanti = 0;
                break;
            case 2:     //$tipo =   2   mese corrente ORDINE INVERTITO
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $iniziomese, 0, $inizioanno))); //Primo del mese rispetto a oggi
                $reverseinavanti = 0;
                break;
            case 3:     //$tipo =   2   ultimi 3 mesi ORDINE INVERTITO
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $iniziomese - 2, 0, $inizioanno))); //Primo del mese di 3 mesi prima rispetto a oggi
                $reverseinavanti = 0;
                break;
            case 4:     //$tipo =   4   prossimi 60 giorni 
                list($oa, $om, $og) = explode('-', date('Y-m-d')); //OGGI
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $om, $og + 60, $oa))); //60 giorni dopo rispetto a oggi
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $om, $og - 1, $oa))); // 2 giorni prima di oggi
                $reverseinavanti = 1;
                break;
            case 5:     //$tipo =   5   ultimi 3 mesi 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $iniziomese - 2, 0, $inizioanno))); //Primo del mese di 3 mesi prima rispetto a oggi
                $reverseinavanti = 1;
                break;
            case 6:     //$tipo =   6   ultimi 2 mesi 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $iniziomese - 1, 0, $inizioanno))); //Primo del mese di 1 mesi prima rispetto a oggi
                $reverseinavanti = 1;
                break;
            case 7:     //$tipo =   7   dall'iniziodell'anno a oggi 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, 1, 0, $inizioanno))); //Primo dell'anno rispetto a oggi
                $reverseinavanti = 1;
                break;
            case 8:     //$tipo =   8   ultimi 4 mesi 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $iniziomese - 3, 0, $inizioanno))); //Primo del mese di 3 mesi prima rispetto a oggi
                $reverseinavanti = 1;
                break;
            case 9:     //$tipo =   9   dall'inizio dell'anno precedente a oggi 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, 1, 0, $inizioanno - 1))); //Primo dell'anno precedente rispetto a oggi
                $reverseinavanti = 1;
                break;
            case 10:     //$tipo =   10   mese corrente
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $iniziomese, 0, $inizioanno))); //Primo del mese rispetto a oggi
                $reverseinavanti = 1;
                break;

            case 2017:     //$tipo =   2017   anno 2017 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', "2017-12-31");
                list($fineanno, $finemese, $finegiorno) = explode('-', "2016-12-31");
                $reverseinavanti = 1;
                break;
            case 2018:     //$tipo =   2018   anno 2018 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', "2018-12-31");
                list($fineanno, $finemese, $finegiorno) = explode('-', "2017-12-31");
                $reverseinavanti = 1;
                break;
            case 2019:     //$tipo =   2019   anno 2019 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', "2019-12-31");
                list($fineanno, $finemese, $finegiorno) = explode('-', "2018-12-31");
                $reverseinavanti = 1;
                break;
            case 2020:     //$tipo =   2020   anno 2020 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', "2020-12-31");
                list($fineanno, $finemese, $finegiorno) = explode('-', "2019-12-31");
                $reverseinavanti = 1;
                break;
            case 2021:     //$tipo =   2020   anno 2020 
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', "2021-12-31");
                list($fineanno, $finemese, $finegiorno) = explode('-', "2020-12-31");
                $reverseinavanti = 1;
                break;
            default:    //ieri e oggi
                list($inizioanno, $iniziomese, $iniziogiorno) = explode('-', date('Y-m-d')); //OGGI
                list($fineanno, $finemese, $finegiorno) = explode('-', date('Y-m-d', mktime(0, 0, 0, $iniziomese, $iniziogiorno - 1, $inizioanno))); //ieri
        }

        $easterDay = $this->easterDay($inizioanno);
        //Costruisco la tabella
        $y = $inizioanno;
        $m = $iniziomese;
        $d = $iniziogiorno;
        $datai = date('Y-m-d', mktime(0, 0, 0, $iniziomese, $iniziogiorno, $inizioanno));
        $dataf = date('Y-m-d', mktime(0, 0, 0, $finemese, $finegiorno, $fineanno));

        while ($datai != $dataf) {
            $nomemeseatt = $mesiAnno[$m - 1];
            $daydata = $this->dayType($m, $d, $y, $easterDay);

            $listagiorni[] = [
                'anno' => $y,
                'mese' => $m,
                'giorno' => $d,
                'nomemese' => $nomemeseatt,
                'nomegiorno' => $daydata['weekday'],
                'tipogiorno' => $daydata['F'],
            ];
            list($y, $m, $d) = explode('-', date('Y-m-d', mktime(0, 0, 0, $m, $d - 1, $y)));
            $datai = date('Y-m-d', mktime(0, 0, 0, $m, $d, $y));
        }

        if ($reverseinavanti == 1) {
            $listagiorni = array_reverse($listagiorni);
        }

        if ($composto == '1') {
            $ricomponi = array();

            foreach ($listagiorni as $l) {
                $ricomponi[$l['anno']][$l['nomemese']][$l['giorno']] = $l;
            }

            $listagiorni = $ricomponi;
        }

        return $listagiorni;
    }





    function sottrai_giornilavorativi($daytime, $giorni)
    {     //Sottrae a daytime $giorni lavorativi e restituisce la data in mysql
        $i = 0;
        $timestamp = $this->mysql_to_unix($daytime);
        do {
            $timestamp = $timestamp - (24 * 60 * 60);
            $giorno = date('Y-m-d H:i:s', $timestamp);
            if ($this->isgiornolavorativo($giorno)) {
                $i += 1;
            }
        } while ($i <= $giorni);

        return $giorno;
    }

    function prossimo_giorno_lavorativo()
    {
        $adesso = time();
        $next_work_day = '';
        do {
            $adesso += 86400;
            if ($this->isgiornolavorativo($this->unix_to_human($adesso, TRUE, 'eu'))) {
                $next_work_day = $this->unix_to_human($adesso, TRUE, 'eu');
            }
        } while ($next_work_day === '');

        return $next_work_day;
    }

    function buildCalendar()
    {

        $yearYouWant = intval(date('Y'));

        $yearNum = $yearYouWant;
        $mesiAnno = array(
            "GENNAIO", "FEBBRAIO", "MARZO", "APRILE", "MAGGIO",
            "GIUGNO", "LUGLIO", "AGOSTO", "SETTEMBRE", "OTTOBRE",
            "NOVEMBRE", "DICEMBRE"
        );
        //$yearNum = empty($yearYouWant) ? $yearnow : $yearYouWant;
        //$this->logo = $logoPath;

        $easterDay = $this->Calendario_model->easterDay($yearNum);


        for ($i = 1; $i <= 12; $i++) {
            $monthName = $mesiAnno[$i - 1];
            $calArray[$monthName] = $this->Calendario_model->buildMonths($i, $yearNum, $easterDay);
        }
        $data['calarray'] = $calArray;
        $data['yearnum'] = $yearNum;
        $data['easterday'] = $easterDay;
        $this->load->view('prova/prova_dati3', $data);
    }

    function unix_to_human($time = '', $seconds = FALSE, $fmt = 'us')
    {
        $r = date('Y', $time) . '-' . date('m', $time) . '-' . date('d', $time) . ' ';

        if ($fmt === 'us') {
            $r .= date('h', $time) . ':' . date('i', $time);
        } else {
            $r .= date('H', $time) . ':' . date('i', $time);
        }

        if ($seconds) {
            $r .= ':' . date('s', $time);
        }

        if ($fmt === 'us') {
            return $r . ' ' . date('A', $time);
        }

        return $r;
    }

    function mysql_to_unix($datestr = '')
    {
        if ($datestr === '') {
            return FALSE;
        }

        $gg = substr($datestr, 8, 2); //   2016-08-31 00:00:00
        $mm = substr($datestr, 5, 2);
        $yyyy = substr($datestr, 0, 4);
        $hh = substr($datestr, -8, 2);
        $ii = substr($datestr, -5, 2);
        $ss = substr($datestr, -2, 2);
        $unix = mktime($hh, $ii, $ss, $mm, $gg, $yyyy);

        return $unix;
    }
}

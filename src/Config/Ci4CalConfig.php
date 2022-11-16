<?php

namespace Matleyx\CI4P\Config;

class Ci4CalConfig
{
    public $months = array(
        ARRAY ('month_number' => '01', 'month_name' => 'GENNAIO',),
        ARRAY ('month_number' => '02', 'month_name' => 'FEBBRAIO',),
        ARRAY ('month_number' => '03', 'month_name' => 'MARZO',),
        ARRAY ('month_number' => '04', 'month_name' => 'APRILE',),
        ARRAY ('month_number' => '05', 'month_name' => 'MAGGIO',),
        ARRAY ('month_number' => '06', 'month_name' => 'GIUGNO',),
        ARRAY ('month_number' => '07', 'month_name' => 'LUGLIO',),
        ARRAY ('month_number' => '08', 'month_name' => 'AGOSTO',),
        ARRAY ('month_number' => '09', 'month_name' => 'SETTEMBRE',),
        ARRAY ('month_number' => '10', 'month_name' => 'OTTOBRE',),
        ARRAY ('month_number' => '11', 'month_name' => 'NOVEMBRE',),
        ARRAY ('month_number' => '12', 'month_name' => 'DICEMBRE',),
    );

    public $days = array(
        ARRAY ('day_number' => '1', 'day_name' => 'Lunedi',),
        ARRAY ('day_number' => '2', 'day_name' => 'Martedi',),
        ARRAY ('day_number' => '3', 'day_name' => 'Mercoledi',),
        ARRAY ('day_number' => '4', 'day_name' => 'Giovedi',),
        ARRAY ('day_number' => '5', 'day_name' => 'Venerdi',),
        ARRAY ('day_number' => '6', 'day_name' => 'Sabato',),
        ARRAY ('day_number' => '7', 'day_name' => 'Domenica',),
    );

    public $national_holiday = array(
        1 => array(1, 6),
        4 => array(25),
        5 => array(1),
        6 => array(2),
        8 => array(10, 15),
        11 => array(1),
        12 => array(8, 25, 26)
    );

    public $factory_holiday = array(
        2022 => array(
            1 => array(3,4,5,7),
            6 => array(3),
            8 => array(1,2, 3, 4, 5, 8, 9, 11, 12, 16, 17, 18, 19, 22, 23, 24, 25, 26),				
            10 => array(31),
            12 => array(9, 27, 28, 29, 30, 31),
            )
    );





}

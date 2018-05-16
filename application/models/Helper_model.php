<?php

/**
 * @class helper_model
 * @brief Model-klasse hulp bij bepaalde handelingen
 *
 * Model-klasse die alle methodes bevat om te speciale en ingewikkelde handelingen uit te voeren.
 */
class helper_model extends CI_Model
{

    /**
     *Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Berekent de start en einde van een bepaalde week
     *
     * @param $date Dit is datum waar de week van is
     *
     * @return De start en einde van de week
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getStartEnEindeWeek($date)
    {
        $today = date('U', strtotime($date));

        $dow = date('w', $today);
        $offset = $dow - 1;
        if ($offset < 0) {
            $offset = 6;
        }

        $start = $today - ($offset * 86400);
        $einde = $start + (6 * 86400);

        $datum = array("start" => (date("Y-m-d", $start) . ' 00:00:00'), "einde" => (date("Y-m-d", $einde) . ' 00:00:00'));
        return $datum;
    }

    /**
     * Haalt de unikie waardes uit de array
     *
     * @param $array De array
     * @param $array De waarde die uniek moet zijn
     *
     * @return De start en einde van de week
     *
     * Gemaakt door Michiel Olijslagers
     */
    function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val->$key, $key_array)) {
                $key_array[$i] = $val->$key;
                array_push($temp_array, $val);
            }
            $i++;
        }
        return $temp_array;
    }

}

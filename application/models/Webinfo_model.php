<?php

/**
 * @class Webinfo_model
 * @brief Model-klasse voor webinfo (informatie op startscherm)
 *
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel Webinfo.
 */

class Webinfo_model extends CI_Model
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert een array met alle webinfo gegevens uit de tabel Webinfo.
     * @return een array van alle webinfo
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getAll()
    {
        $query = $this->db->get('webinfo');
        $webinfo = array();
        foreach ($query->result() as $waarde) {
            $webinfo["$waarde->naam"] = "$waarde->waarde";
        }
        return $webinfo;
    }

    /**
     * Retourneert een array met alle webinfo gegevens uit de tabel Webinfo.
     * @return een array van alle webinfo
     *
     * Gemaakt door Nico Claes
     */
    function getAllNames()
    {
        $query = $this->db->get('webinfo');
        $webinfo = array();
        foreach ($query->result() as $waarde) {
            array_push($webinfo, $waarde->naam);
        }
        return $webinfo;
    }

    /**
     * Update alle webinfo met de nieuwe waarde uit de array $webinfo in de tabel Webinfo.
     * @param $webinfo Een array van alle tekst die is ingegeven om weer te geven op de startpagina.
     *
     * Gemaakt door Nico Claes
     */
    function update($webinfo)
    {
        foreach ($webinfo as $naam => $waarde) {
            $webinfoElement = array('waarde' => $waarde);
            $this->db->where('naam', $naam);
            $this->db->update('webinfo', $webinfoElement);
        }
    }
}

<?php

/**
 * @class AdresRit_model
 * @brief Model-klasse voor adresRit, hier wordt een adres aan een rit gekoppeld
 *
 * Model-klasse die alle methodes bevat om te data uit de database-tabel adresRit te halen.
 */
class AdresRit_model extends CI_Model
{

    /**
     *Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Haalt een bepaald type adres op van een bepaalde rit
     *
     * @param $ritId Dit is het id van de gevraagde rit
     * @param $type Dit is het het type van het adres
     * @see Adres_model::getById()
     *
     * @return Het opgevraagde adres
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getByRitIdAndType($ritId, $type)
    {
        $this->load->model('adres_model');

        $this->db->select('*');
        $this->db->where('ritId', $ritId);
        $this->db->where('typeAdresId', $type);
        $query = $this->db->get('adresRit');
        $array = array();
        $array = $query->row();

        $array->adres = $this->adres_model->getById($array->adresId);
        return $array;
    }

    /**
     * Checked of er een rit terug is
     *
     * @param $ritId Dit is het id van de gevraagde rit
     *
     * @return True of False naargelang er een terugrit is of niet
     *
     * Gemaakt door Michiel Olijslagers
     */
    function terugRit($ritId)
    {
        $this->db->where('ritId', $ritId);
        $query = $this->db->get('adresRit');

        $rows = array();
        $check = 0;
        $rows = $query->result();
        foreach ($rows as $row) {
            if ($row->typeAdresId == 3) {
                $check++;
            }
            if ($row->typeAdresId == 4) {
                $check++;
            }
            if ($check == 2) {
                return True;
            }
        }
        return False;
    }

    /**
     * Heeft al de informatie terug wanneer een persoon op een bepaald adres moet zijn bij een bepaalde rit
     *
     * @param $ritId Dit is het id van de gevraagde rit
     * @param $typeId Dit is het type adres dat gevraagd is
     *
     * @return Al de data die in de adresRit tabel zit
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getTime($ritId, $typeId)
    {
        $this->db->where('ritId', $ritId);
        $this->db->where('typeAdresId', $typeId);
        $query = $this->db->get('adresRit');

        return $query->row()->tijd;
    }

    /**
     * Haalt al de adressen op die gebruikt worden binnen een bepaalde rit
     *
     * @param $ritId Dit is het id van de gevraagde rit
     * @see adres_model::getById()
     *
     * @return Al de adressen van een rit
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getAdressen($ritId)
    {
        $this->load->model('adres_model');
        $this->db->where('ritId', $ritId);
        $query = $this->db->get('adresRit');
        $rows = $query->result();

        $adressen = array();
        foreach ($rows as $row) {
            array_push($adressen, $this->adres_model->getById($row->adresId));
        }

        return $adressen;
    }

    /**
     * Slaat info op in de adresRit tabel
     *
     * @param $ritId Dit is het id van d e rit
     * @param $adresId Dit is het  id van het adres
     * @param $typeAdresId Dit is type id van het ingegeven adres
     * @param $tijd Dit is de tijd voor het adres
     *
     * Gemaakt door Michiel Olijslagers
     */
    function saveAdresRit($ritId, $adresId, $typeAdresId, $tijd)
    {
        $data = array(
            'ritId' => $ritId,
            'adresId' => $adresId,
            'typeAdresId' => $typeAdresId,
            'tijd' => $tijd
        );
        $this->db->insert('adresRit', $data);
    }
}

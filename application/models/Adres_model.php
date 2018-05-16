<?php

/**
 * @class Adres_model
 * @brief Model-klasse voor adressen
 *
 * Model-klasse die alle methodes bevat om te data uit de database-tabel adres te halen.
 */
class Adres_model extends CI_Model
{

    /**
     *Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Geeft het opgevraagde adres terug aan de hand van een id
     *
     * @param $id Dit is adres id
     *
     * @return Het opgevraagde adres
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('adres');
        return $query->row();
    }

    /**
     * Retourneert alle records uit de tabel adres.
     * @return Alle records
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getAll()
    {
        $query = $this->db->get('adres');
        return $query->result();
    }

    /**
     * Retourneert een leeg adres met alle eigenschappen van een record uit de tabel adres.
     * @return Een leeg adres
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getEmpty()
    {
        $adres = new stdClass();

        $adres->id = null;
        $adres->straat = null;
        $adres->huisnummer = null;
        $adres->gemeente = null;
        $adres->postcode = null;

        return $adres;
    }

    /**
     * Gaat de gegevens van een adres uit de tabel adres aanpassen naar de gegevens uit $adres.
     * @param $adres Een adres object met nieuwe gegevens
     *
     * Gemaakt door Geffrey Wuyts
     */
    function updateAdres($id, $adresGegevens)
    {
        $this->db->set('straat', $adresGegevens->straat);
        $this->db->set('huisnummer', $adresGegevens->huisnummer);
        $this->db->set('gemeente', $adresGegevens->gemeente);
        $this->db->set('postcode', $adresGegevens->postcode);
        $this->db->where('id', $id);
        $this->db->update('adres');
    }

    /**
     * Gaat een nieuwe adres aanmaken in de tabel adres met de gegevens van $adres.
     * @param $adres Een adres object
     * @return Het id van het nieuwe record
     *
     * Gemaakt door Geffrey Wuyts
     */
    function insertAdres($adres)
    {
        $data = array(
            'huisnummer' => $adres->huisnummer,
            'straat' => $adres->straat,
            'gemeente' => $adres->gemeente,
            'postcode' => $adres->postcode,
        );

        $this->db->insert('adres', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    /**
     * Voegt een adres toe aan de database
     *
     * @param $huisnummer Dit is het huisnummer van het adres
     * @param $straat Dit is het straat van het adres
     * @param $gemeente Dit is het gemeente van het adres
     * @param $postcode Dit is het postcode van het adres
     *
     * @return Het adres id
     *
     * Gemaakt door Michiel Olijslagers
     */
    function addAdres($huisnummer, $straat, $gemeente, $postcode)
    {
        $data = array(
            'huisnummer' => $huisnummer,
            'straat' => $straat,
            'gemeente' => $gemeente,
            'postcode' => $postcode,
        );

        $this->db->insert('adres', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    /**
     * Gaat kijken in de tabel adres of er een adres is met de zelfde gegevens uit $adres.
     *
     * @param $adres Een adres object
     * @return bool
     *
     * Gemaakt door Geffrey Wuyts
     */
    function bestaatAdresAl($adres)
    {
        $data = array(
            'huisnummer' => $adres->huisnummer,
            'straat' => $adres->straat,
            'gemeente' => $adres->gemeente,
            'postcode' => $adres->postcode,
        );
        $this->db->where($data);
        $query = $this->db->get('adres');
        $query->row();
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->id;
        } else {
            return false;
        }
    }

    /**
     * Kijkt of een bepaalt adres al in de database zit
     *
     * @param $huisnummer Dit is het huisnummer van het adres
     * @param $straat Dit is het straat van het adres
     * @param $gemeente Dit is het gemeente van het adres
     * @param $postcode Dit is het postcode van het adres
     *
     * @return Het adres id als dit adres bestaat
     *
     * Gemaakt door Michiel Olijslagers
     */
    function bestaatAdres($huisnummer, $straat, $gemeente, $postcode)
    {
        $this->db->where('huisnummer', $huisnummer);
        $this->db->where('straat', $straat);
        $this->db->where('gemeente', $gemeente);
        $this->db->where('postcode', $postcode);
        $query = $this->db->get('adres');
        $result = $query->row();
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->id;
        } else {
            return false;
        }
    }
}

<?php

/**
 * @class Functie_model
 * @brief Model-klasse voor functies
 *
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel functie.
 */
class Functie_model extends CI_Model {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel functie.
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     *
     * Gemaakt door Geffrey Wuyts
     */
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('functie');
        return $query->row();
    }

    /**
     * Retourneert alle records met id<$totId uit de tabel functie.
     * @param $totId Een getal om te zeggen tot welke functie je wilt opvragen
     * @return Alle opgevraagde records
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getAll($totId){
        $this->db->where('id <', $totId);
        $query = $this->db->get('functie');
        return $query->result();
    }

    /**
     * Retourneert een lege record met alle eigenschappen van een record uit de tabel functie.
     * @return Een lege record
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getEmpty(){
        $functie = new stdClass();

        $this->db->where('id', 1);
        $query = $this->db->get('functie');
        $voorbeeldFunctie = $query->row();

        foreach ($voorbeeldFunctie as $attribut => $waarde){
            $functie->$attribut = null;
        }

        return $functie;
    }
                        
}

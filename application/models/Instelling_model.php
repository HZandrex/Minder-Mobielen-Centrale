<?php

/**
 * @class Instelling_model
 * @brief Model-klasse voor instellingen
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel instelling.
 */

class Instelling_model extends CI_Model {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Retourneert records uit de tabel instelling.
     * @return Alle records
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getAll()
    {
        $query = $this->db->get('instelling');
        return $query->result();
    }

    /**
     * Gaat elke instelling in de tabel instelling aanpassen. De nieuwe gegevens worden uit $instellingen gehaald.
     * @param $instellingen Een array van instellingen
     *
     * Gemaakt door Geffrey Wuyts
     */
    function wijzig($instellingen){
        foreach ($instellingen as $instelling){
            $this->db->where('id', $instelling->id);
            $this->db->update('instelling', $instelling);
        }
    }

	function getValueById($id){
		$this->db->where('id', $id);
		$query = $this->db->get('instelling');
		return $query->row();
	}
}

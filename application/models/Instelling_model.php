<?php

/**
 * @class Webinfo_model
 * @brief Model-klasse voor webinfo (informatie op startscherm)
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel Webinfo.
 */

class Instelling_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Retourneert een array met alle webinfo gegevens uit de tabel Webinfo.
     * @return een array van alle webinfo
     */
    /*function getAll()
    {
        $query = $this->db->get('instelling');
        $instellingen = array();
        foreach($query->result() as $instelling){
            $instellingen["$instelling->naam"] = "$instelling->waarde";
        }
        return $instellingen;
    }*/
    function getAll()
    {
        $query = $this->db->get('instelling');
        return $query->result();
    }

    function wijzig($instellingen){
        foreach ($instellingen as $instelling){
            $this->db->where('id', $instelling->id);
            $this->db->update('instelling', $instelling);
        }
    }
	
	function getValueById($id){
		/**
			* Haalt een waarde van instelling uit de db
			*
			* @param $id Het id van de instelling
			* @see Gemaakt door Michiel Olijslagers
			* @return De instelling
		*/
		$this->db->where('id', $id);
		$query = $this->db->get('instelling');
		return $query->row();
	}
}

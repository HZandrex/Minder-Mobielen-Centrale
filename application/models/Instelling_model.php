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
        $query = $this->db->get('Instelling');
        $instellingen = array();
        foreach($query->result() as $instelling){
            $instellingen["$instelling->naam"] = "$instelling->waarde";
        }
        return $instellingen;
    }*/
    function getAll()
    {
        $query = $this->db->get('Instelling');
        return $query->result();
    }

    function wijzig($instellingen){
        foreach ($instellingen as $instelling){
            $this->db->where('id', $instelling->id);
            $this->db->update('Instelling', $instelling);
        }
    }
	
	function getValueById($id){
		$this->db->where('id', $id);
		$query = $this->db->get('Instelling');
		return $query->row();
	}
}

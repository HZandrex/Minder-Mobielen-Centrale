<?php

class adresrit_model extends CI_Model {

    // +----------------------------------------------------------
    // | MMC - adresrit_model.php
    // +----------------------------------------------------------
    // | 2 ITF - 2017-2018
    // +----------------------------------------------------------
    // | Model voor adresrit gegevens.
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }

	//Functie moet nog aangepast worden. Zorgen dat men de gegevens van de ingelogde persoon toont.
    function getByRitIdAndType($id, $type)
    {
		$this->db->select('*');
        $this->db->where('ritid', $id);
		$this->db->where('typeAdresId', $type);
        $query = $this->db->get('adresrit');
		$array = array();
		$array = $query->row();
		
		$this->load->model('adres_model');
		$array->adres = $this->adres_model->getById($array->AdresId);
        return $array;
    }
	
	function terugRit($id){
        $this->db->where('RitId', $id);
		$query = $this->db->get('adresrit');
		
		$rows = array();
		$check = 0;
		$rows = $query->result();
		foreach($rows as $row){
			if($row->TypeAdresId == 3){
				$check++;
			}
			if($row->TypeAdresId == 4){
				$check++;
			}
			if($check == 2){
				return True;
			}
		}
		return False;
	}
                        
}

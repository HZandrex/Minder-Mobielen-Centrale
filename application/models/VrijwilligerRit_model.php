<?php

class VrijwilligerRit_model extends CI_Model {

    // +----------------------------------------------------------
    // | MMC - vrijwilligerrit_model.php
    // +----------------------------------------------------------
    // | 2 ITF - 2017-2018
    // +----------------------------------------------------------
    // | Model voor vrijwilligerrit gegevens.
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }

	//Functie moet nog aangepast worden. Zorgen dat men de gegevens van de ingelogde persoon toont.
    function getByRitId($id)
    {
		$this->db->select('*');
        $this->db->where('ritid', $id);
        $query = $this->db->get('VrijwilligerRit');
		
		$this->load->model('status_model');
		$array = array();
		$array = $query->row();
		$array->status = $this->status_model->getById($array->statusId);
        return $array;
    }

                        
}

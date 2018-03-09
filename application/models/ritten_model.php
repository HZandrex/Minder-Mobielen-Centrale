<?php

class ritten_model extends CI_Model {

    // +----------------------------------------------------------
    // | mmc - Ritten_model.php
    // +----------------------------------------------------------
    // | 2 ITF - 2017-2018
    // +----------------------------------------------------------
    // | Ritten model
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }

    function getById($mmid)
    {
        $this->db->where('mmid', $mmid);
		//$this->db->order_by('datum', 'asc');
		$query = $this->db->get('rit');
        $ritten = array();
        $ritten = $query->result();
		
		$this->load->model('adres_model');
		foreach($ritten as $rit){
			$rit->heenvertrek = $this->adres_model->getAdresRit;
		}
		
        return $ritten;
    }
                        
}

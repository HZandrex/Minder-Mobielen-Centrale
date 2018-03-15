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
		$this->load->model('adresrit_model');
		$this->load->model('vrijwilligerrit_model');
		foreach($ritten as $rit){
			$rit->heenvertrek = $this->adresrit_model->getByRitIdAndType($rit->id, 1);
			$rit->heenaankomst = $this->adresrit_model->getByRitIdAndType($rit->id, 2);
			if($this->adresrit_model->terugRit($rit->id)){
				$rit->terugvertrek = $this->adresrit_model->getByRitIdAndType($rit->id, 3);
				$rit->terugaankomst = $this->adresrit_model->getByRitIdAndType($rit->id, 4);
			}
			$rit->status = $this->vrijwilligerrit_model->getByRitId($rit->id);
		}
		
        return $ritten;
    }
                        
}

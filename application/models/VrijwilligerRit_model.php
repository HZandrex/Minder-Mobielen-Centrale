<?php

class VrijwilligerRit_model extends CI_Model {

    /**
        *Constructor
    */
    function __construct()
    {
        parent::__construct();
    }

    /**
        *Haalt al de vrijwilligers met hun status op van een bepaalde rit 
        *
        *@param $id is het id van de gevraagde rit
        *@see Status_model::getById()
        *@return Al de statussen van een rit ivm de vrijwilliger
    */
    function getByRitId($id)
    {
	$this->db->select('*');
        $this->db->where('ritid', $id);
	$this->db->where('statusId', '2');
        $query = $this->db->get('VrijwilligerRit');
        $array = array();
        $array = $query->row();

        $this->load->model('status_model');
        $this->load->model('gebruiker_model');

        $array->status = $this->status_model->getById($array->statusId);
        $array->vrijwilliger = $this->gebruiker_model->get($array->vrijwilligerId);
        return $array;
    }
    
    /**
        *Haalt alle ritten op van een bepaalde vrijwilliger 
        *
        *@param $id is het id van de gevraagde vrijwilliger
        *@see Status_model::getById()
        *@return Al de statussen van een rit ivm de vrijwilliger
    */
    function getByVrijwilligerId($id)
    {
        $this->load->model('rit_model');
        $this->load->model('status_model');
        
	$this->db->select('*');
        $this->db->where('vrijwilligerId', $id);
        $query = $this->db->get('VrijwilligerRit');
        $ritten = array();
        $ritten = $query->result();

        $i =0;
        foreach($ritten as $rit){
            $rit->rit = $this->rit_model->getByRitId($rit->ritId);
            
            $rit->status = $this->status_model->getById($rit->statusId);
            
            $i++;
        }
        return $ritten;
    }
    
    function updateVrijwilligerRit($vrijwilligerRit)
    {
        $this->load->model('rit_model');
        $this->load->model('status_model');
        
    }
                        
}

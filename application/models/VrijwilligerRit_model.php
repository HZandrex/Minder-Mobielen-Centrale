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
        $this->db->where('ritId', $id);
        $query = $this->db->get('vrijwilligerRit');
        $vrijwilligerRit = $query->row();

        $this->load->model('status_model');
        $this->load->model('gebruiker_model');

        $vrijwilligerRit->status = $this->status_model->getById($vrijwilligerRit->statusId);
        $vrijwilligerRit->vrijwilliger = $this->gebruiker_model->get($vrijwilligerRit->gebruikerVrijwilligerId);
        return $vrijwilligerRit;
    }
    
    /**
        *Haalt alle ritten op van een bepaalde vrijwilliger 
        *
        *@param $id is het id van de gevraagde vrijwilliger
        *@see Status_model::getById()
        *@return Al de statussen van een rit ivm de vrijwilliger
    */
    function getVrijwilligerRittenByVrijwilligerId($id)
    {
        $this->load->model('rit_model');
        $this->load->model('status_model');
        
	$this->db->select('*');
        $this->db->where('gebruikerVrijwilligerId', $id);
        $query = $this->db->get('vrijwilligerRit');
        $ritten = $query->result();

        foreach($ritten as $rit){
            $rit->rit = $this->rit_model->getByRitId($rit->ritId);
            $rit->status = $this->status_model->getById($rit->statusId);
        }
        return $ritten;
    }
    
    function getVrijwilligerRitByVrijwilligerRitId($ritId)
    {
        $this->load->model('rit_model');
        $this->load->model('status_model');
        
	$this->db->select('*');
        $this->db->where('ritId', $ritId);
        $query = $this->db->get('vrijwilligerRit');
        $vrijwilligerRit = $query->result()[0];
        
        $vrijwilligerRit->rit = $this->rit_model->getByRitId($vrijwilligerRit->ritId);
        $vrijwilligerRit->status = $this->status_model->getById($vrijwilligerRit->statusId);
        return $vrijwilligerRit;
    }
    
    function updateVrijwilligerRit($vrijwilligerRit)
    {
        $this->db->set('statusId', $vrijwilligerRit->statusId);
        $this->db->where('id', $vrijwilligerRit->id);
        $this->db->insert('vrijwilligerRit');
        
        $this->db->set('opmerkingVrijwilliger', $vrijwilligerRit->statusId);
        $this->db->set('extraKost', $vrijwilligerRit->extraKost);
        if($vrijwilligerRit->statusId == 1){
            $this->db->insert('statusId', 3);
        }
        $this->db->where('id', $vrijwilligerRit->ritId);
        $this->db->insert('rit');
    }
    
    function updateStatusRitten($ritId,$ritStatusId)
    {
        if($ritStatusId == 1){
            $data = array('statusId' => 3);
        }else if($ritStatusId == 2){
            $data = array('statusId' => 2);
        }
        $this->db->where('id', $ritId);
        $this->db->update('rit', $data);
        
        $data = array('statusId' => $ritStatusId);
        $this->db->where('ritId', $ritId);
        $this->db->update('vrijwilligerRit', $data);
    }
                        
}

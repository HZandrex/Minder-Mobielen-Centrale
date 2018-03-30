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
        $query = $this->db->get('VrijwilligerRit');
		$array = array();
		$array = $query->row();
		
		$this->load->model('status_model');
		$this->load->model('gebruiker_model');
		
		$array->status = $this->status_model->getById($array->statusId);
		$array->vrijwilliger = $this->gebruiker_model->get($array->vrijwilligerId);
        return $array;
    }

                        
}

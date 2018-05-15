<?php

/**
 * @class VrijwilligerRit_model
 * @brief Model-klasse voor vrijwilliger en rit koppeling
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel vrijwilligerRit.
 */
class VrijwilligerRit_model extends CI_Model {

    /**
        *Constructor
    */
    function __construct()
    {
        parent::__construct();
    }

    /**
        * Haalt al de vrijwilligers met hun status op van een bepaalde rit 
        *
        * @param $id is het id van de gevraagde rit
        * @see Status_model::getById()
		* @see gebruiker_model::get()
        * @return Al de statussen van een rit ivm de vrijwilliger
		*
		* Gemaakt door Michiel Olijslagers
    */
    function getByRitId($id)
    {
		$this->db->select('*');
        $this->db->where('ritId', $id);
		$this->db->where('ritId', $id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
        $query = $this->db->get('vrijwilligerRit');
        $vrijwilligerRit = $query->row();
		
		if(count($vrijwilligerRit) > 0){
			$this->load->model('status_model');
			$this->load->model('gebruiker_model');

			$vrijwilligerRit->status = $this->status_model->getById($vrijwilligerRit->statusId);
			$vrijwilligerRit->vrijwilliger = $this->gebruiker_model->get($vrijwilligerRit->gebruikerVrijwilligerId);
		}  
        return $vrijwilligerRit;
    }
    
    /**
        * Haalt alle ritten op van een bepaalde vrijwilliger 
        *
        * @param $id is het id van de gevraagde vrijwilliger
		* @see rit_model::getByRitId()
        * @see Status_model::getById()
        * @return Al de statussen van een rit ivm de vrijwilliger
		*
		* Gemaakt door Michiel Olijslagers
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
    
	/**
        * Haalt 1 rit op van een bepaalde vrijwilliger 
        *
        * @param $id is het id van de gevraagde vrijwilliger
		* @see rit_model::getByRitId()
        * @see Status_model::getById()
        * @return 1 rit status
		*
		* Gemaakt door Michiel Olijslagers
    */
    function getVrijwilligerRitByVrijwilligerRitId($id)
    {
        $this->load->model('rit_model');
        $this->load->model('status_model');
        
		$this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('vrijwilligerRit');
        $vrijwilligerRit = $query->result()[0];
        
        $vrijwilligerRit->rit = $this->rit_model->getByRitId($vrijwilligerRit->ritId);
        $vrijwilligerRit->status = $this->status_model->getById($vrijwilligerRit->statusId);
        return $vrijwilligerRit;
    }
    
	/**
        * Update een record van vrijwilligerRit
        *
        * @param $vrijwilligerRit Dit is al de informatie die aangepast moet worden
		*
		* Gemaakt door Michiel Olijslagers
    */
    function updateVrijwilligerRit($vrijwilligerRit)
    {
        $data = array('opmerkingVrijwilliger' => $vrijwilligerRit->opmerkingVrijwilliger);
        if($vrijwilligerRit->extraKost != 0){
            $data += ['extraKost' => $vrijwilligerRit->extraKost];
        }
        if($vrijwilligerRit->statusId == 1){
            $data += ['statusId'=> 3];
        }
        
        $this->db->update('rit', $data);
    }
    
	/** 
		* Past de status van een rit aan samen met die van een vrijwilliger
		*
		* @param $ritId Dit is het id van de rit
		* @param $ritStatusId Dit is de status naar waar de rit aangepast moet worden
		* @see rit_model::updateStatusRit()
		*
		* Gemaakt door Nico Claes
		* Aangepast door Michiel Olijslagers
	*/
    function updateStatusRitten($ritId,$ritStatusId)
    {
		$this->load->model('rit_model');
        if($ritStatusId == 1){
			$this->rit_model->updateStatusRit($ritId, 3);
        }else if($ritStatusId == 2){
			$this->rit_model->updateStatusRit($ritId, 2);
        }

        $data = array('statusId' => $ritStatusId);
        $this->db->where('ritId', $ritId);
        $this->db->update('vrijwilligerRit', $data);
    }
	
	/** 
		* Past de status van vrijwilliger aan
		*
		* @param $ritId Dit is het id van de rit
		* @param $ritStatusId Dit is de status naar waar de rit aangepast moet worden
		*
		* Gemaakt door Nico Claes
		* Aangepast door Michiel Olijslagers
	*/
	function updateStatusVrijwilligerRit($ritId,$ritStatusId){
		$data = array('statusId' => $ritStatusId);
        $this->db->where('ritId', $ritId);
        $this->db->update('vrijwilligerRit', $data);
	}

	/**
        * Haalt een vrijwilliger op van een bepaalde rit
        *
        * @param $ritId Dit is het id de rit
		* @see functieGebruiker_model::getAllGebruikersByFunction()
        * @return al de vrijwilligers bij een bepaalde rit
		*
		* Gemaakt door Michiel Olijslagers
    */
	function getVrijwilligerByRit($ritId){
		$this->load->model('functieGebruiker_model');
		$vrijwilligers = $this->functieGebruiker_model->getAllGebruikersByFunction(3);
		
		foreach($vrijwilligers as $vrijwilliger){
			$this->db->where('ritId', $ritId);
			$this->db->where('gebruikerVrijwilligerId', $vrijwilliger->id);
			$data = array();
			$query = $this->db->get('vrijwilligerRit');
			$data = $query->result();
			if(count($data) > 0){
				$this->db->where('ritId', $ritId);
				$this->db->where('gebruikerVrijwilligerId', $vrijwilliger->id);
				$query = $this->db->get('vrijwilligerRit');
				$mening = $query->row();
				$vrijwilliger->mening = $mening->statusId;
			}else{
				$vrijwilliger->mening = "0";
			}
			
		}

        return $vrijwilligers;
	}
	
	/**
        * Koppelt een vrijwilliger aan een rit
        *
        * @param $ritId Dit is het id de rit
		* @param $vrijwilligerId Het id van de vrijwilliger
		* @param $alEen Bool om te kijken of er al een vrijwilliger aan de rit gekoppeld is
        * @return 'done' wanneer de functie afgehandeld is
		*
		* Gemaakt door Michiel Olijslagers
    */
	function koppelVrijwilliger($ritId, $vrijwilligerId, $alEen){
		if($alEen){
			$this->db->where('ritId', $ritId);
			$this->db->where('statusId', '3');
			$this->db->delete('vrijwilligerRit');
		}
		
		$data = array(
			'gebruikerVrijwilligerId' => $vrijwilligerId,
			'ritId' => $ritId,
			'statusId' => '3'
		);
		$this->db->insert('vrijwilligerRit', $data);
		
		return 'done';
	}
	
	/**
        * Verwijderd een status van een bepaalde vrijwilliger bij een bepaalde rit
        *
        * @param $ritId Dit is het id de rit
		* @param $vrijwilligerId Het id van de vrijwilliger
		*
		* Gemaakt door Michiel Olijslagers
    */
	function resetVrijwilliger($ritId, $vrijwilligerId){
		$this->db->where('ritId', $ritId);
		$this->db->where('gebruikerVrijwilligerId', $vrijwilligerId);
		$this->db->delete('vrijwilligerRit');
	}
                        
}

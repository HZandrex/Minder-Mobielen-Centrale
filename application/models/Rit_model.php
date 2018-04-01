<?php

/**
	* @class Rit_model
	* @brief Model-klasse voor rit, dit zijn al de ritten in het systeem
	* 
	* Model-klasse die alle methodes bevat om te data uit de database-tabel rit te halen.
*/
class Rit_model extends CI_Model {

	/**
		*Constructor
	*/
    function __construct()
    {
        parent::__construct();
    }

	
	
	/**
		*Helpt met het sorteren van de ritten op datum
		*
		*@param $a de functie usort zal hier automatisch een array insteken
		*@param $b de functie usort zal hier automatisch een array insteken
		*@return het verschil tussen beide tijden
	*/
	function date_compare($a, $b)
	{
		$t1 = strtotime($a->heenvertrek->tijd);
		$t2 = strtotime($b->heenvertrek->tijd);
		return $t1 - $t2;
	} 
	
	/**
		*Haalt al de informatie op van al de ritten waar het id van de minder mobiele meegegeven wordt
		*
		*@param $mmid Dit is het id van de gevraagde rit
		*@see Adresrit_model::getByRitIdAndType()
		*@see Adresrit_model::terugRit()
		*@see vrijwilligerrit_model::getByRitId()
		*@return al de opgevraagde ritten
	*/
    function getByMMCId($mmid)
    {
		$this->load->model('adresrit_model');
		$this->load->model('status_model');
		
        $this->db->where('mmid', $mmid);
		$query = $this->db->get('Rit');
        $ritten = array();
        $ritten = $query->result();
		
		$i =0;
		foreach($ritten as $rit){
			$rit->heenvertrek = $this->adresrit_model->getByRitIdAndType($rit->id, 1);
			$rit->heenaankomst = $this->adresrit_model->getByRitIdAndType($rit->id, 2);
			if($this->adresrit_model->terugRit($rit->id)){
				$rit->terugvertrek = $this->adresrit_model->getByRitIdAndType($rit->id, 3);
				$rit->terugaankomst = $this->adresrit_model->getByRitIdAndType($rit->id, 4);
			}
			$rit->status = $this->status_model->getById($rit->statusId);
			if(new DateTime() > new DateTime($rit->heenvertrek->tijd)){
				unset($ritten[$i]);
			}
			$i++;
		}
		usort($ritten, array($this, "date_compare"));
        return $ritten;
    }		
	
	/**
		*Haalt al de informatie op van een rit waar het id van de rit meegegeven is
		*
		*@param $mmid Dit is het id van de gevraagde rit
		*@see Adres_model::getByRitId()
		*@return al de opgevraagde rit
	*/
	function getByRitId($id){
		$this->load->model('adresrit_model');
		$this->load->model('status_model');	
		$this->load->model('google_model');		
		$this->load->model('gebruiker_model');	
		$this->load->model('vrijwilligerrit_model');
		
		$this->db->where('id', $id);
		$query = $this->db->get('Rit');
		
		$rit = $query->result();		
		
		$rit[0]->heenvertrek = $this->adresrit_model->getByRitIdAndType($rit[0]->id, 1);
		$rit[0]->heenaankomst = $this->adresrit_model->getByRitIdAndType($rit[0]->id, 2);

		$rit[0]->heen = $this->google_model->getReisTijd($rit[0]->heenvertrek->adresId, $rit[0]->heenaankomst->adresId, $rit[0]->heenvertrek->tijd)->rows[0]->elements[0];
		
		if($this->adresrit_model->terugRit($rit[0]->id)){
			$rit[0]->terugvertrek = $this->adresrit_model->getByRitIdAndType($rit[0]->id, 3);
			$rit[0]->terugaankomst = $this->adresrit_model->getByRitIdAndType($rit[0]->id, 4);
			$rit[0]->terug = $this->google_model->getReisTijd($rit[0]->terugvertrek->adresId, $rit[0]->terugaankomst->adresId, $rit[0]->terugvertrek->tijd)->rows[0]->elements[0];
		}
		$rit[0]->status = $this->status_model->getById($rit[0]->statusId);
		$rit[0]->MM = $this->gebruiker_model->get($rit[0]->mmId);
		if($rit[0]->status->id == 2){
			$rit[0]->vrijwilliger = $this->vrijwilligerrit_model->getByRitId($rit[0]->id);
		}
		
		return $rit[0];
	}
	
	function getAantalRitten($mmId, $date){
		$this->load->model('adresrit_model');
		$this->load->model('helper_model');
		
		$datum = $this->helper_model->getStartEnEindeWeek($date);
		$aantalRitten = 0;
		
		$this->db->where('mmId', $mmId);
		$query = $this->db->get('Rit');
		$ritten = $query->result();
		
		foreach($ritten as $rit){
			$rit->tijd = $this->adresrit_model->getTime($rit->id, 1);
			if($rit->tijd > $datum['start'] && $rit->tijd < $datum['einde']){
				$aantalRitten++;
			}
		}		
		return $aantalRitten;
	}	
	
	function getAllVoorGebruiker($mmId){
		$this->load->model('gebruiker_model');
		$this->load->model('helper_model');
		$this->load->model('adresrit_model');
		
		$adressen = array();
		array_push($adressen, $this->gebruiker_model->getWithFunctions($mmId)->adres);
		
		$this->db->where('mmId', $mmId);
		$query = $this->db->get('Rit');
		$ritten = $query->result();
		
		foreach($ritten as $rit){
			$ritAdressen = $this->adresrit_model->getAdressen($rit->id);
			foreach($ritAdressen as $adres){
				array_push($adressen, $adres);
			}
		}
		
		return $this->helper_model->unique_multidim_array($adressen, 'id');
	}
	
	
                        
}

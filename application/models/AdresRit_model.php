<?php
/**
	* @class AdresRit_model
	* @brief Model-klasse voor adresRit, hier wordt een adres aan een rit gekoppeld
	* 
	* Model-klasse die alle methodes bevat om te data uit de database-tabel adresRit te halen.
*/
class AdresRit_model extends CI_Model {
	
	/**
		*Constructor
	*/
    function __construct()
    {
        parent::__construct();
    }

	/**
		*Haalt een bepaald type adres op van een bepaalde rit
		*
		*@param $ritId Dit is het id van de gevraagde rit
		*@param $type Dit is het het type van het adres
		*@see Adres_model::getById()
		*@return Het opgevraagde adres
	*/
    function getByRitIdAndType($ritId, $type)
    {
		$this->load->model('adres_model');
		
		$this->db->select('*');
        $this->db->where('ritId', $ritId);
		$this->db->where('typeAdresId', $type);
        $query = $this->db->get('adresRit');
		$array = array();
		$array = $query->row();
		
		$array->adres = $this->adres_model->getById($array->adresId);
        return $array;
    }
	
	/**
		*Checked of er een rit terug is
		*
		*@param $ritId Dit is het id van de gevraagde rit
		*@return True of False naargelang er een terugrit is of niet
	*/
	function terugRit($ritId){
        $this->db->where('ritId', $ritId);
		$query = $this->db->get('adresRit');
		
		$rows = array();
		$check = 0;
		$rows = $query->result();
		foreach($rows as $row){
			if($row->typeAdresId == 3){
				$check++;
			}
			if($row->typeAdresId == 4){
				$check++;
			}
			if($check == 2){
				return True;
			}
		}
		return False;
	}
	
	function getTime($ritId, $typeId){
		$this->db->where('ritId', $ritId);
		$this->db->where('typeAdresId', $typeId);
		$query = $this->db->get('adresRit');
		
		return $query->row()->tijd;
	}
	
	function getAdressen($ritId){
		$this->load->model('adres_model');
		$adressen = array();
		$this->db->where('ritId', $ritId);
		$query = $this->db->get('adresRit');
		$rows = $query->result();
		
		foreach($rows as $row){
			array_push($adressen, $this->adres_model->getById($row->adresId));
		}
		
		return $adressen;
	}
	
	function saveAdresRit($ritId, $adresId, $typeAdresId, $tijd){
		$data = array(
			'ritId' => $ritId,
			'adresId' => $adresId,
			'typeAdresId' => $typeAdresId,
			'tijd' => $tijd
		);
		$this->db->insert('adresRit', $data);
	}
                        
}

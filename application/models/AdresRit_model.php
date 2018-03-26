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
		$this->db->select('*');
        $this->db->where('ritid', $ritId);
		$this->db->where('typeAdresId', $type);
        $query = $this->db->get('AdresRit');
		$array = array();
		$array = $query->row();
		
		$this->load->model('adres_model');
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
        $this->db->where('RitId', $ritId);
		$query = $this->db->get('AdresRit');
		
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
                        
}

<?php
/**
	* @class Adres_model
	* @brief Model-klasse voor adres
	* 
	* Model-klasse die alle methodes bevat om te data uit de database-tabel adres te halen.
*/
class Adres_model extends CI_Model {

	/**
		*Constructor
	*/
    function __construct()
    {
        parent::__construct();
    }

	/**
		*Geeft het opgevraagde adres terug aan de hand van een id
		*
		*@param $id Dit is adres id
		*@return Het opgevraagde adres
	*/
    function getById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('Adres');
        return $query->row();
    }

	function updateAdres($id,$adresGegevens)
	{
		$this->db->set('straat', $adresGegevens->straat);
		$this->db->set('huisnummer', $adresGegevens->huisnummer);
		$this->db->set('gemeente', $adresGegevens->gemeente);
		$this->db->set('postcode', $adresGegevens->postcode);
		$this->db->where('id', $id);
		$this->db->update('Adres');
	}

	function addAdres($huisnummer, $straat, $gemeente, $postcode){
		$data = array(
			'huisnummer' => $huisnummer,
			'straat' => $straat,
			'gemeente' => $gemeente,
			'postcode' => $postcode,
		);

		$this->db->insert('Adres', $data);
		$insert_id = $this->db->insert_id();
		
		return $insert_id;
	}
	
	function bestaatAdres($huisnummer, $straat, $gemeente, $postcode){
		$this->db->where('huisnummer', $huisnummer);
		$this->db->where('straat', $straat);
		$this->db->where('gemeente', $gemeente);
		$this->db->where('postcode', $postcode);
		$query = $this->db->get('Adres');
		$result = $query->row();
		if($query->num_rows() > 0){
			$result = $query->row();
			return $result->id;
		}else{
			return false;
		}
	}
}

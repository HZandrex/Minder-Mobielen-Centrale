<?php
/**
	* @class Adres_model
	* @brief Model-klasse voor adressen
	*
	* Model-klasse die alle methodes bevat om te data uit de database-tabel adres te halen.
*/
class Adres_model extends CI_Model {

	function __construct()
    {
		/**
			*Constructor
		*/
        parent::__construct();
    }

    function getById($id)
    {
		/**
			* Geeft het opgevraagde adres terug aan de hand van een id
			*
			* @param $id Dit is adres id
			* @see Gemaakt door Michiel Olijslagers
			* @return Het opgevraagde adres
		*/
        $this->db->where('id', $id);
        $query = $this->db->get('adres');
        return $query->row();
    }

    function getAll()
    {
        $query = $this->db->get('adres');
        return $query->result();
    }

    function getEmpty(){
        $adres = new stdClass();

        $adres->id = null;
        $adres->straat = null;
        $adres->huisnummer = null;
        $adres->gemeente = null;
        $adres->postcode = null;

        return $adres;
    }

	function updateAdres($id,$adresGegevens)
	{
		$this->db->set('straat', $adresGegevens->straat);
		$this->db->set('huisnummer', $adresGegevens->huisnummer);
		$this->db->set('gemeente', $adresGegevens->gemeente);
		$this->db->set('postcode', $adresGegevens->postcode);
		$this->db->where('id', $id);
		$this->db->update('adres');
	}

    function insertAdres($adres){  
        $data = array(
            'huisnummer' => $adres->huisnummer,
            'straat' => $adres->straat,
            'gemeente' => $adres->gemeente,
            'postcode' => $adres->postcode,
        );

        $this->db->insert('adres', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

	function addAdres($huisnummer, $straat, $gemeente, $postcode){       
		 /**
			* Voegt een adres toe aan de database
			*
			* @param $huisnummer Dit is het huisnummer van het adres
			* @param $straat Dit is het straat van het adres
			* @param $gemeente Dit is het gemeente van het adres
			* @param $postcode Dit is het postcode van het adres
			* @see Gemaakt door Michiel Olijslagers
			* @return Het adres id 
		*/ 
		$data = array(
			'huisnummer' => $huisnummer,
			'straat' => $straat,
			'gemeente' => $gemeente,
			'postcode' => $postcode,
		);

		$this->db->insert('adres', $data);
		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

    function bestaatAdresAl($adres){
        $data = array(
            'huisnummer' => $adres->huisnummer,
            'straat' => $adres->straat,
            'gemeente' => $adres->gemeente,
            'postcode' => $adres->postcode,
        );
        $this->db->where($data);
        $query = $this->db->get('adres');
        $query->row();
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->id;
        }else{
            return false;
        }
    }

	function bestaatAdres($huisnummer, $straat, $gemeente, $postcode){
		 /**
			* Kijkt of een bepaalt adres al in de database zit
			*
			* @param $huisnummer Dit is het huisnummer van het adres 
			* @param $straat Dit is het straat van het adres
			* @param $gemeente Dit is het gemeente van het adres
			* @param $postcode Dit is het postcode van het adres
			* @see Gemaakt door Michiel Olijslagers    
			* @return Het adres id als dit adres bestaat
		*/            
		$this->db->where('huisnummer', $huisnummer);
		$this->db->where('straat', $straat);
		$this->db->where('gemeente', $gemeente);
		$this->db->where('postcode', $postcode);
		$query = $this->db->get('adres');
		$result = $query->row();
		if($query->num_rows() > 0){
			$result = $query->row();
			return $result->id;
		}else{
			return false;
		}
	}
}

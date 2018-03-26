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
}

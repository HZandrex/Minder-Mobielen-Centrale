<?php
/**
	* @class Status_model
	* @brief Model-klasse voor status
	* 
	* Model-klasse die alle methodes bevat om te data uit de database-tabel status te halen.
*/
class Status_model extends CI_Model {

    /**
		*Constructor
	*/
    function __construct()
    {
        parent::__construct();
    }

	//Functie moet nog aangepast worden. Zorgen dat men de gegevens van de ingelogde persoon toont.
	/**
		*Haalt de status naam op waar het id $id is 
		*
		*@param $id is het id van de gevraagde status
		*@return Al de informatie over de bepaalde status
	*/
    function getById($id)
    {
		$this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('status');
        return $query->row();
    }
	
	function getAll(){
		$query = $this->db->get('status');
        return $query->result();
	}

                        
}

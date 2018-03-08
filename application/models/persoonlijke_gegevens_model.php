<?php

class persoonlijke_gegevens_model extends CI_Model {

    // +----------------------------------------------------------
    // | MMC - persoonlijke_gegevens.php
    // +----------------------------------------------------------
    // | 2 ITF - 2017-2018
    // +----------------------------------------------------------
    // | Model voor persoonlijke gegevens.
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }

	//Functie moet nog aangepast worden. Zorgen dat men de gegevens van de ingelogde persoon toont.
    function get()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('gebruiker');
		$gegevens = $query->result();
		
		$this->load->model('adres_model');
		$gegevens->adres = $this->adres_model->get($gegevens->AdresID);
			
		
		var_dump($gegevens);
		exit;
		
        return $gegevens;
    }
                        
}

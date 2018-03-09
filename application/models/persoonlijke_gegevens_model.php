<?php

class persoonlijke_gegevens_model extends CI_Model {

    // +----------------------------------------------------------
    // | MMC - persoonlijke_gegevens_model.php
    // +----------------------------------------------------------
    // | 2 ITF - 2017-2018
    // +----------------------------------------------------------
    // | Model voor persoonlijke gegevens op te halen.
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
		$gegevens = $query->row();
		
		$this->load->model('adres_model');
		$this->load->model('communicatiemiddel_model');
		
		$adresID = $gegevens->AdresID;
		$voorkeurID = $gegevens->VoorkeurID;
		
		$gegevens->adres = $this->adres_model->get($adresID);
		$gegevens->voorkeur = $this->communicatiemiddel_model->get($voorkeurID);
		
        return $gegevens;
    }
                        
}

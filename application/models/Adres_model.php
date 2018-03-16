<?php

class Adres_model extends CI_Model {

    // +----------------------------------------------------------
    // | MMC - adres_model.php
    // +----------------------------------------------------------
    // | 2 ITF - 2017-2018
    // +----------------------------------------------------------
    // | Model voor adres gegevens.
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }

	//Functie moet nog aangepast worden. Zorgen dat men de gegevens van de ingelogde persoon toont.
    function getById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('adres');
        return $query->row();
    }
                        
}

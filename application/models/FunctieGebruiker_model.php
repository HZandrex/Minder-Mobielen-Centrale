<?php

class FunctieGebruiker_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*function get($gebruikersId)
    {
        $this->db->where('gebruikerId', $gebruikerId);
        $query = $this->db->get('functieGebruiker');
        return $query->result();
    }*/
	
    function getWithName($gebruikerId)
    {
        $this->db->where('gebruikerId', $gebruikerId);
        $this->db->where('eindTijd', null);
        $query = $this->db->get('functieGebruiker');
        $functiesGebruiker = $query->result();
        
        $this->load->model('functie_model');
        $functies = array();
        foreach ($functiesGebruiker as $functieGebruiker) {
            array_push($functies ,$this->functie_model->get($functieGebruiker->functieId));
        }
        
        return $functies;
    }

    function functieGebruikerBestaat($gebruikerId, $functieId)
    {
        $this->db->where('gebruikerId', $gebruikerId);
        $this->db->where('functieId', $functieId);
        $this->db->where('eindTijd', null);
        $query = $this->db->get('functieGebruiker');;
        $functiesGebruiker = $query->row();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $functiesGebruiker->id;
        }
    }

    function getEmpty(){
        $this->load->model('functie_model');
        $functies = array();
        array_push($functies, $this->functie_model->getEmpty());

        return $functies;
    }

    function voegToe($functieGebruiker){
        if(!$this->db->insert('functieGebruiker', $functieGebruiker)){
            return false;
        }
        return true;

    }

    function verwijderen($id){
        $functieGebruiker = new stdClass();
        $functieGebruiker->eindTijd = date("Y-m-d H:i:s");

        $this->db->where('id', $id);
        if(!$this->db->update('functieGebruiker', $functieGebruiker)){
            return false;
        }
        return true;
    }


    function getAllGebruikersByFunction($functieId)
    {
        $this->db->where('functieId', $functieId);
        $this->db->where('eindTijd', null);
        $query = $this->db->get('functieGebruiker');
        $functies =  $query->result();
        $this->load->model('gebruiker_model');
        $gebruikers = array();
        foreach ($functies as $functie) {
            array_push($gebruikers, $this->gebruiker_model->get($functie->gebruikerId));
        }
        return $gebruikers;
    }

}

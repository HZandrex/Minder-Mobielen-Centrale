<?php
/**
 * @class CoachMindermobiele_model
 * @brief Model-klasse voor CoachMinderMobiele
 *
 * Model-klasse die alle methodes bevat om te data uit de database-tabel status te halen.
 */
class CoachMindermobiele_model extends CI_Model {

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

        $this->db->where('coachId', $id);
        $query = $this->db->get('CoachMinderMobiele');
        $naam = $query->result();
        $this->load->model('rit_model');
        $this->load->model('gebruiker_model');
        $ritten = array();
        foreach ($naam as $mm){
            $temp= $this->rit_model->getByMMCId($mm->mmId);
            if (!empty($temp)){
                foreach ($temp as $rit){
                    $rit->persoon = $this->gebruiker_model->get($mm->mmId);
                    array_push($ritten, $rit);
                }


            }


        }
        return $ritten;
    }




}
<?php
/**
 * @class CoachMinderMobiele_model
 * @brief Model-klasse voor coachMinderMobiele
 *
 * Model-klasse die alle methodes bevat om te data uit de database-tabel status te halen.
 */
class CoachMinderMobiele_model extends CI_Model {

    /**
     *Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     *Haalt de status naam op waar het id $id is
     *
     *@param $id is het id van de gevraagde status
     *@return Al de informatie over de bepaalde status
     */
    function getById($id)
    {
        $this->db->where('gebruikerCoachId', $id);
        $query = $this->db->get('coachMinderMobiele');
        $naam = $query->result();
        $this->load->model('rit_model');
        $this->load->model('gebruiker_model');
        $ritten = array();
        foreach ($naam as $mm){
            $temp= $this->rit_model->getByMMCId($mm->gebruikerMinderMobieleId);
            if (!empty($temp)){
                foreach ($temp as $rit){
                    $rit->persoon = $this->gebruiker_model->get($mm->gebruikerMinderMobieleId);
                    array_push($ritten, $rit);
                }
            }
        }
        return $ritten;
    }
	
	function getMMById($id)
	{
		$this->db->where('gebruikerCoachId', $id);
		$query = $this->db->get('coachMinderMobiele');
		$mmIds = $query->result();
		$this->load->model('gebruiker_model');
		$minderMobielen = array();
		
		
		foreach ($mmIds as $mmId){
			array_push($minderMobielen,$this->gebruiker_model->get($mmId->gebruikerMinderMobieleId));
		}
		
		return $minderMobielen;
	}




}
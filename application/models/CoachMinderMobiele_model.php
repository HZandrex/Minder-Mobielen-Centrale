<?php
/**
 * @class CoachMinderMobiele_model
 * @brief Model-klasse voor coachMinderMobiele
 *
 * Model-klasse die alle methodes bevat om te data uit de database-tabel status te halen.
 */
class CoachMinderMobiele_model extends CI_Model {
 
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
         * Deze functie haalt alle mindermobiele op die bij een specifieke coach behoren.
         *
         * @see rit_model::getByMMCId()
         * @see gebruiker_model::get()
         * @see Gemaakt door Lorenz Cleymans
         */
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
        /**
         * Deze functie haalt alle ID's op waar een $id is gelijk aan een gebruikerCoachId
         *
         * @see gebruiker_model::get()
         * @see Gemaakt door Lorenz Cleymans
         */
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
        
        function getBijhorendeCoaches($minderMobieleId){
            $this->load->model('gebruiker_model');
            
            $this->db->where('gebruikerMinderMobieleId', $minderMobieleId);
            $this->db->where('eindDatum', NULL);
            $query = $this->db->get('coachMinderMobiele');
            $bijHorendeCoachesMinderMobiele = $query->result();
            foreach ($bijHorendeCoachesMinderMobiele as $coachMinderMobiele){
                $coachMinderMobiele->coach = $this->gebruiker_model->get($coachMinderMobiele->gebruikerCoachId);
            }
            
            return $bijHorendeCoachesMinderMobiele;
        }
        
        function getOverschotCoaches(){
            $this->load->model('gebruiker_model');
            
            $this->db->where('functieId', 2);
            $this->db->where('eindTijd', NULL);
            $query = $this->db->get('functieGebruiker');
            $coaches = $query->result();
            
            foreach ($coaches as $coach){
                $coach->coach = $this->gebruiker_model->get($coach->gebruikerId);
            }
            
            return $coaches;
        }
        
        function archiveerBijhorendeCoach($coachMinderMobieleId){
            
            $this->db->set('eindDatum', date('Y-m-d H:i:s'));
            $this->db->where('id', $coachMinderMobieleId);
            $this->db->where('eindDatum', NULL);
            $this->db->update('coachMinderMobiele');
        }
        
        function voegToeBijhorendeCoach($minderMobieleId, $coachId){
            $data = array(
                'gebruikerMinderMobieleId' => $minderMobieleId,
                'gebruikerCoachId' => $coachId,
                'startDatum' => date('Y-m-d H:i:s')
            );

            $this->db->insert('coachMinderMobiele', $data);
            return $this->db->insert_id();
        }
}
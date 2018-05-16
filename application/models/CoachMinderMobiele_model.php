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
         * @see Rit_model::getByMMCId()
         * @see Gebruiker_model::get()
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
         * Deze functie haalt alle ID's op waar een $id is gelijk aan een gebruikerCoachId.
         *
         * @parm $id Een id van een minder mobiele gebruiker.
         * @see Gebruiker_model::get()
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
        
        /**
        * Deze functie haalt alle coaches op die bij een minder mobiele behoort.
        *
        * @parm $minderMobieleId Een id van een minder mobiele gebruiker.
        * @see Gebruiker_model::get()
        * 
        * @return De bijhorende coaches van een minder mobiele.
        *
        * Gemaakt door Nico Claes
         */
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
        
        /**
        * Deze functie haalt alle coaches op die actief zijn.
        *
        * @return Alle actieve coaches.
        * 
        * Gemaakt door Nico Claes
        */
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
        
        /**
        * Deze functie archiveerd een coach die tot een minder mobiele gebruiker behoorde.
        *
        * @parm $coachMinderMobieleId Een id van een coach.
        *
        * Gemaakt door Nico Claes
         */
        function archiveerBijhorendeCoach($coachMinderMobieleId){
            
            $this->db->set('eindDatum', date('Y-m-d H:i:s'));
            $this->db->where('id', $coachMinderMobieleId);
            $this->db->where('eindDatum', NULL);
            $this->db->update('coachMinderMobiele');
        }
        
        /**
        * Deze functie maakt een nieuwe coach mindermobiele relatie.
        *
        * @return Het nieuwe id dat is aangemaakt.
        *
        * Gemaakt door Nico Claes
         */
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
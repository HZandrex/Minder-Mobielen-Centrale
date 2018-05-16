<?php

/**
 * @class Rit_model
 * @brief Model-klasse voor rit, dit zijn al de ritten in het systeem
 *
 * Model-klasse die alle methodes bevat om te data uit de database-tabel rit te halen.
 */
class Rit_model extends CI_Model
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Helpt met het sorteren van de ritten op datum
     *
     * @param $a de functie usort zal hier automatisch een array insteken
     * @param $b de functie usort zal hier automatisch een array insteken
     * @return het verschil tussen beide tijden
     *
     * Gemaakt door Michiel Olijslagers
     */
    function date_compare($a, $b)
    {
        $t1 = strtotime($a->heenvertrek->tijd);
        $t2 = strtotime($b->heenvertrek->tijd);
        return $t1 - $t2;
    }

    /**
     * Haalt al de informatie op van al de ritten waar het id van de minder mobiele meegegeven wordt
     *
     * @param $mmid Dit is het id van de mindermobiele
     * @see Adresrit_model::getByRitIdAndType()
     * @see Adresrit_model::terugRit()
     * @return al de opgevraagde ritten
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getByMMCId($mmid)
    {
        $this->load->model('adresRit_model');
        $this->load->model('status_model');

        $this->db->where('gebruikerMinderMobieleId', $mmid);
        $query = $this->db->get('rit');
        $ritten = array();
        $ritten = $query->result();

        $i = 0;
        foreach ($ritten as $rit) {
            $rit->heenvertrek = $this->adresRit_model->getByRitIdAndType($rit->id, 1);
            $rit->heenaankomst = $this->adresRit_model->getByRitIdAndType($rit->id, 2);
            if ($this->adresRit_model->terugRit($rit->id)) {
                $rit->terugvertrek = $this->adresRit_model->getByRitIdAndType($rit->id, 3);
                $rit->terugaankomst = $this->adresRit_model->getByRitIdAndType($rit->id, 4);
            }
            $rit->status = $this->status_model->getById($rit->statusId);
            if (new DateTime() > new DateTime($rit->heenvertrek->tijd)) {
                unset($ritten[$i]);
            }
            $i++;
        }
        usort($ritten, array($this, "date_compare"));
        return $ritten;
    }

    /**
     * Haalt al de informatie op van al de ritten
     *
     * @see Adresrit_model::getByRitIdAndType()
     * @see Adresrit_model::terugRit()
     * @see status_model::getById()
     * @see gebruiker_model::get()
     * @see vrijwilligerRit_model::getByRitId()
     * @return al de ritten
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getAllRitten()
    {
        $this->load->model('adresRit_model');
        $this->load->model('status_model');
        $this->load->model('gebruiker_model');
        $this->load->model('vrijwilligerRit_model');

        $query = $this->db->get('rit');
        $ritten = array();
        $ritten = $query->result();

        $i = 0;
        foreach ($ritten as $rit) {
            $rit->heenvertrek = $this->adresRit_model->getByRitIdAndType($rit->id, 1);
            $rit->heenaankomst = $this->adresRit_model->getByRitIdAndType($rit->id, 2);
            if ($this->adresRit_model->terugRit($rit->id)) {
                $rit->terugvertrek = $this->adresRit_model->getByRitIdAndType($rit->id, 3);
                $rit->terugaankomst = $this->adresRit_model->getByRitIdAndType($rit->id, 4);
            }
            $rit->status = $this->status_model->getById($rit->statusId);
            $rit->MM = $this->gebruiker_model->get($rit->gebruikerMinderMobieleId);
            if (count($this->vrijwilligerRit_model->getByRitId($rit->id)) > 0) {
                $rit->vrijwilliger = $this->vrijwilligerRit_model->getByRitId($rit->id);
            }
            if (new DateTime() > new DateTime($rit->heenvertrek->tijd)) {
                unset($ritten[$i]);
            }
            $i++;
        }
        usort($ritten, array($this, "date_compare"));
        return $ritten;
    }

    /**
     * Haalt al de informatie op van een rit waar het id van de rit meegegeven is
     *
     * @param $id Dit is het id van de gevraagde rit
     * @see Adres_model::getByRitId()
     * @return de opgevraagde rit
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getByRitId($id)
    {
        $this->load->model('adresRit_model');
        $this->load->model('status_model');
        $this->load->model('google_model');
        $this->load->model('gebruiker_model');
        $this->load->model('vrijwilligerRit_model');

        $this->db->where('id', $id);
        $query = $this->db->get('rit');

        $rit = $query->result()[0];

        $rit->heenvertrek = $this->adresRit_model->getByRitIdAndType($rit->id, 1);
        $rit->heenaankomst = $this->adresRit_model->getByRitIdAndType($rit->id, 2);

        $rit->heen = $this->google_model->getReisTijd($rit->heenvertrek->adresId, $rit->heenaankomst->adresId, $rit->heenvertrek->tijd);

        if ($this->adresRit_model->terugRit($rit->id)) {
            $rit->terugvertrek = $this->adresRit_model->getByRitIdAndType($rit->id, 3);
            $rit->terugaankomst = $this->adresRit_model->getByRitIdAndType($rit->id, 4);
            $rit->terug = $this->google_model->getReisTijd($rit->terugvertrek->adresId, $rit->terugaankomst->adresId, $rit->terugvertrek->tijd);
        }
        $rit->status = $this->status_model->getById($rit->statusId);
        $rit->MM = $this->gebruiker_model->get($rit->gebruikerMinderMobieleId);
        if (count($this->vrijwilligerRit_model->getByRitId($rit->id)) > 0) {
            $rit->vrijwilliger = $this->vrijwilligerRit_model->getByRitId($rit->id);
        }

        return $rit;
    }

    /**
     * Telt het aantal ritten van een mindermobiele op 1 week
     *
     * @param $mmid Dit is het id van de minder mobiele
     * @param $date Dit is de datum die in de week ligt waar we gaan tellen hoeveel ritten er zijn
     * @see adresRit_model::getTime()
     * @see helper_model::getStartEnEindeWeek()
     * @return het aantal ritten dat een mindermobiele heeft op 1 week
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getAantalRitten($mmId, $date)
    {
        $this->load->model('adresRit_model');
        $this->load->model('helper_model');

        $datum = $this->helper_model->getStartEnEindeWeek($date);
        $aantalRitten = 0;

        $this->db->where('gebruikerMinderMobieleId', $mmId);
        $query = $this->db->get('rit');
        $ritten = $query->result();

        foreach ($ritten as $rit) {
            $rit->tijd = $this->adresRit_model->getTime($rit->id, 1);
            if ($rit->tijd > $datum['start'] && $rit->tijd < $datum['einde']) {
                $aantalRitten++;
            }
        }
        return $aantalRitten;
    }

    /**
     * Geeft al de adressen van een bepaalde gebruiker
     *
     * @param $mmid Dit is het id van de minder mobiele
     * @see gebruiker_model::getWithFunctions()
     * @see helper_model::unique_multidim_array()
     * @see adresRit_model::getAdressen()
     * @return Geeft al de adressen terug van een bepaalde minder mobiele
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getAllVoorGebruiker($mmId)
    {
        $this->load->model('gebruiker_model');
        $this->load->model('helper_model');
        $this->load->model('adresRit_model');

        $adressen = array();
        $temp = array();
        $huisadres = $this->gebruiker_model->getWithFunctions($mmId)->adres;
        if (!empty($huisadres)) {
            array_push($adressen, $huisadres);
        }
        $this->db->where('gebruikerMinderMobieleId', $mmId);
        $query = $this->db->get('rit');
        $ritten = $query->result();

        foreach ($ritten as $rit) {
            $ritAdressen = $this->adresRit_model->getAdressen($rit->id);
			var_dump($ritAdressen);
            foreach ($ritAdressen as $adres) {
                array_push($temp, $adres);
				var_dump($adres);
            }
        }

        function cmp($a, $b)
        {
			var_dump($a);
			var_dump($b);
            return strcmp($a->straat, $b->straat);
        }
		var_dump($temp);
        usort($temp, "cmp");

        $adressen = array_merge($adressen, $temp);
        if (!empty($adressen[0])) {
            return $this->helper_model->unique_multidim_array($adressen, 'id');
        } else {
            return $adressen;
        }

    }

    /**
     * Voegt een nieuwe rit toe aan database
     *
     * @param $mmid Dit is het id van de rit
     * @param $opmerkingKlant Dit is de opmerking van de klant van de rit
     * @param $opmerkingVrijwilliger Dit is de opmerking van de vrijwilliger van de rit
     * @param $prijs Dit is de prijs van de rit
     * @param $extraKost Dit is de extra kost van de rit
     * @param $statusId Dit is het id van de status van de rit
     * @param $heenTerug Dit is een boolean die aanduid of er een heen en terug rit is
     * @param $heenStartAdresId Dit is het adres id van de start van de heen rit
     * @param $heenEindeAdresId Dit is het adres is van het inde van de heen rit
     * @param $terugStartAdresId Dit is het adres id van de start van de terug rit
     * @param $terugEindeAdresId Dit is het adres id van het einde van de terug rit
     * @param $startTijdHeen Dit is de start tijd van de heen rit
     * @param $startTijdTerug Dit is de start tijd van de terug rit
     * @param $heenDatum Dit is de datum van de heen rit
     * @param $terugDatum Dit is de datum van de terug rit
     * @see adresRit_model::saveAdresRit()
     * @return Het id van de net ingevoegde rit
     *
     * Gemaakt door Michiel Olijslagers
     */
    function saveNewRit($mmId, $opmerkingKlant, $opmerkingVrijwilliger, $prijs, $extraKost, $statusId, $heenTerug, $heenStartAdresId, $heenEindeAdresId, $terugStartAdresId, $terugEindeAdresId, $startTijdHeen, $startTijdTerug, $heenDatum, $terugDatum)
    {
        $this->load->model('adresRit_model');

        $ritId = 0;
        $data = array(
            'gebruikerMinderMobieleId' => $mmId,
            'opmerkingKlant' => $opmerkingKlant,
            'opmerkingVrijwilliger' => $opmerkingVrijwilliger,
            'prijs' => $prijs,
            'extraKost' => $extraKost,
            'statusId' => $statusId,
        );
        $this->db->insert('rit', $data);
        $ritId = $this->db->insert_id();

        $tijd = substr($heenDatum, 3, 1) . substr($heenDatum, 4, 1) . "/" . substr($heenDatum, 0, 1) . substr($heenDatum, 1, 1) . "/" . substr($heenDatum, 6, 1) . substr($heenDatum, 7, 1) . substr($heenDatum, 8, 1) . substr($heenDatum, 9, 1) . " " . $startTijdHeen . ":00";
        $timesStamp = date('Y-m-d G:i:s', strtotime($tijd));
        var_dump($tijd);
        $this->adresRit_model->saveAdresRit($ritId, $heenStartAdresId, "1", $timesStamp);
        $this->adresRit_model->saveAdresRit($ritId, $heenEindeAdresId, "2", $timesStamp);
        if ($heenTerug) {
            $tijd = substr($terugDatum, 3, 1) . substr($terugDatum, 4, 1) . "/" . substr($terugDatum, 0, 1) . substr($terugDatum, 1, 1) . "/" . substr($terugDatum, 6, 1) . substr($terugDatum, 7, 1) . substr($terugDatum, 8, 1) . substr($terugDatum, 9, 1) . " " . $startTijdTerug . ":00";
            var_dump($tijd);
            $timesStamp = date('Y-m-d G:i:s', strtotime($tijd));
            $this->adresRit_model->saveAdresRit($ritId, $terugStartAdresId, "3", $timesStamp);
            $this->adresRit_model->saveAdresRit($ritId, $terugEindeAdresId, "4", $timesStamp);
        }
        return $ritId;
    }

    /**
     * Update de status van een vrijwilliger bij een rit
     *
     * @param $vrijwilligerRitId Dit is de koppeling tussen rit en vrijwilliger op deze manier wordt de juiste rit en vrijwilliger gekozen
     * @param $statusId Dit is de status naar waar aangepast moet worden
     *
     * Gemaakt door Michiel Olijslagers
     */
    function updateStatusVrijwilligerRit($vrijwilligerRitId, $statusId)
    {
        $data = array('statusId' => $statusId);
        $this->db->where('id', $vrijwilligerRitId);
        $this->db->update('rit', $data);
    }

    /**
     * Past de statsu aan van een rit en van de vrijwilligerrit
     *
     * @param $ritId Dit is het id van de rit
     * @param $ritStatusId Dit is de status naar waar de rit aangepast moet worden
     * @see Adresrit_model::updateStatusVrijwilligerRit()
     *
     * Gemaakt door Nico Claes
     *
     * Aangepast door Michiel Olijslagers
     */
    function updateStatusRitten($ritId, $ritStatusId)
    {
        $this->load->model('adresRit_model');

        $data = array('statusId' => $ritStatusId);
        $this->db->where('id', $ritId);
        $this->db->update('rit', $data);

        $this->adresRit_model->updateStatusVrijwilligerRit($ritId, $ritStatusId);
    }

    /**
     * Past de status van een rit aan
     *
     * @param $ritId Dit is het id van de rit
     * @param $ritStatusId Dit is de status naar waar de rit aangepast moet worden
     *
     * Gemaakt door Nico Claes
     *
     * Aangepast door Michiel Olijslagers
     */
    function updateStatusRit($ritId, $ritStatusId)
    {
        $data = array('statusId' => $ritStatusId);
        $this->db->where('id', $ritId);
        $this->db->update('rit', $data);
    }
}

<?php
/**
	* @class Google_model
	* @brief Model-klasse voor google
	* 
	* Model-klasse die alle methodes bevat om data van de google api te vekrijgen.
*/
class Google_model extends CI_Model {

	/**
		*Constructor
	*/
    function __construct()
    {
        parent::__construct();
    }
	
	/**
		*Geeft het opgevraagde lengte en breete graad van beide start en eind punt
		*
		*@param $adresIdStart Dit is het adres id van het startpunt
		*@param $adresIdDestination Dit is het adres id van het eindpunt
		*@param $startTime Dit is de tijd wanneer de afstand + tijd berekent moet worden
		*@return Afstand in km, afstand in verkeer in km, tijd in u:min:sec
	*/
	function getReisTijd($adresIdStart, $adresIdDestination, $startTime){
		$this->load->model('adres_model');
		$adresStart = $this->adres_model->getById($adresIdStart);
		$adresEinde = $this->adres_model->getById($adresIdDestination);
		
		$url='https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . str_replace(' ', '%20', $adresStart->huisnummer) . '+' . str_replace(' ', '%20', $adresStart->straat) . '+' . str_replace(' ', '%20', $adresStart->gemeente) .'&destinations=' . str_replace(' ', '%20', $adresEinde->huisnummer) . '+' . str_replace(' ', '%20', $adresEinde->straat) . '+' . str_replace(' ', '%20', $adresEinde->gemeente) .'&departure_time=' . date('U', strtotime($startTime)) . '&traffic_model=best_guess&key=AIzaSyDeN_rP-G7r2WxkhdPv5dUFwEnyMe1oDbg';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		return json_decode($response)->rows[0]->elements[0];
	}
	
	
                  
}

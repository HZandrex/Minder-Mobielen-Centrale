<?php
class helper_model extends CI_Model {

	/**
		*Constructor
	*/
    function __construct()
    {
        parent::__construct();
    }
	
	function getStartEnEindeWeek($date){
		$today = date('U', strtotime($date));
		$dow = date('w', $today);
			$offset = $dow - 1;
		if ($offset < 0) {
			$offset = 6;
		}
		
		$start = $today - ($offset * 86400);
		$einde = $start + (6 * 86400);
		
		$datum = array("start"=>(date("Y-m-d", $start) . ' 00:00:00'), "einde"=>(date("Y-m-d", $einde) . ' 00:00:00'));
		return $datum;
	}
	
	function unique_multidim_array($array, $key) { 
		$temp_array = array(); 
		$i = 0; 
		$key_array = array(); 
		
		foreach($array as $val) { 
			if (!in_array($val->$key, $key_array)) { 
				$key_array[$i] = $val->$key; 
				array_push($temp_array, $val);
			} 
			$i++; 
		} 
		return $temp_array; 
	} 
                        
}

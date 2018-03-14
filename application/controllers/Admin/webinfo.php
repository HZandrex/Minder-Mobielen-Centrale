<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webinfo extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Webinfo wijzigen';
        $data['author'] = 'Nico C.';
        
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
         
        $this->load->model('webinfo_model');
        $data['webinfo'] = $this->webinfo_model->getAll();
        
        $partials = array('menu' => 'main_menu', 'inhoud' => 'admin/webinfoWijzigPagina');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function wijzig() {
        $data['titel'] = 'Webinfo wijzigen';
        $data['author'] = 'Nico C.';
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
        
        $webinfo = array();
        array_push($webinfo, $this->input->post('homeTitel'));
        array_push($webinfo, $this->input->post('homeTekst'));
        array_push($webinfo, $this->input->post('contactTelefoon'));
        array_push($webinfo, $this->input->post('contactMail'));
        array_push($webinfo, $this->input->post('contactFax'));
        array_push($webinfo, $this->input->post('contactStraat'));
        array_push($webinfo, $this->input->post('contactStraatNr'));
        array_push($webinfo, $this->input->post('contactGemeente'));
        array_push($webinfo, $this->input->post('contactGemeenteCode'));
        array_push($webinfo, $this->input->post('openingsurenDagen'));
        array_push($webinfo, $this->input->post('openingsurenVanEersteDeel'));
        array_push($webinfo, $this->input->post('openingsurenTotEersteDeel'));
        array_push($webinfo, $this->input->post('openingsurenVanTweedeDeel'));
        array_push($webinfo, $this->input->post('openingsurenTotTweedeDeel'));
        array_push($webinfo, $this->input->post('foto_1'));
        array_push($webinfo, $this->input->post('foto_2'));
        array_push($webinfo, $this->input->post('foto_3'));
        array_push($webinfo, $this->input->post('openingsurenSluitDagen'));
        array_push($webinfo, $this->input->post('openingsurenOpmerking'));
        
        $this->load->model('webinfo_model');
        $data['webinfo'] = $this->webinfo_model->update($webinfo);
        
        redirect('admin/webinfo/index');
    }
}
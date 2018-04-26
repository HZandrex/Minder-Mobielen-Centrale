<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webinfo extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Webinfo wijzigen';
        $data['author'] = 'Nico C.';
        
        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }
         
        $this->load->model('webinfo_model');
        $data['webinfo'] = $this->webinfo_model->getAll();
        
        $partials = array('menu' => 'main_menu', 'inhoud' => 'admin/webinfoWijzigPagina');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function wijzig() {
        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }
        
        $this->load->model('webinfo_model');
        
        $webinfoNamen = $this->webinfo_model->getAllNames();
        $webinfo = $this->webinfo_model->getAll();
                        
        foreach ($webinfoNamen as $info) {
            $webinfo[$info] = $this->input->post($info);
        }
        
        $this->webinfo_model->update($webinfo);
        
        redirect('admin/webinfo');
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webinfo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Laat de wijzig webinfo pagina zien.
     *
     * @see Webinfo_model::getAll()
     *
     * Gemaakt door Nico Claes
     */
    public function index()
    {
        $data['titel'] = 'Webinfo wijzigen';
        $data['author'] = 'N. Claes';

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

    /**
     *  Sla alle webinfo op, op de wijzig webinfo pagina.
     *
     * @see Webinfo_model::getAllNames()
     * @see Webinfo_model::getAll()
     * @see Webinfo_model::update()
     *
     * Gemaakt door Nico Claes
     *
     * Medemogelijk door Geffrey Wuyts
     */
    public function wijzig()
    {
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
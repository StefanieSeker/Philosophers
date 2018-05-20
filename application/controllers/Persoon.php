<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Persoon extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        /**
         * Dit is de constructor.
         */
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
        if (!$this->authex->loggedIn()) {
            redirect('home/login');
        }
    }

    public function index() {
        /**
         * Zorgt ervoor dat de beheerders getoond worden. Wordt standaard getoond bij het openen van de controller.
         */
        $this->load->model('persoon_model');
        $data['beheerders'] = $this->persoon_model->getAllBeheerders();
        $data['title'] = 'Beheerders bekijken';
        $data['nobox'] = true;      // geen extra rand rond hoofdmenu
        $data['user'] = $this->authex->getUserInfo();
        $data['auteur'] = 'Jarne Peeters, Bart Buyens';

        $partials = array('header' => 'main_header', 'content' => 'beheerders_beheren', 'menu' => 'main_menu');
        $this->template->load('main_master', $partials, $data);
    }

    public function ledenLijst() {
        /**
         * Zorgt ervoor dat het overzicht kan gefilterd worden met Ajax.
         */
        $sort = $this->input->get('sort');
        $filterBy = $this->input->get('filterBy');
        $filter = $this->input->get('filter');
        $this->load->model('persoon_model');
        $this->load->model('prijs_model');
        $data['leden'] = $this->persoon_model->getLedenFilter($sort, $filterBy, $filter);
        // geen extra rand rond hoofdmenu
        $data['lidgeld'] = $this->prijs_model->getLidgeld();
        $data['theoriegeld'] = $this->prijs_model->getTheoriegeld();

        $this->load->view("leden_beheren", $data);
    }

    public function ledenOverzicht() {
        /**
         * Zorgt ervoor dat alle leden getoond worden.
         */
        if (!$this->authex->loggedIn()) {
            redirect('home/login');
        }

        $data['title'] = 'Leden beheren';
        $data['auteur'] = 'Stefanie Seker';
        $data['nobox'] = true;      // geen extra rand rond hoofdmenu
        $data['user'] = $this->authex->getUserInfo();

        $partials = array('header' => 'main_header', 'content' => 'ledenlijst', 'menu' => 'main_menu');
        $this->template->load('main_master', $partials, $data);
    }

    public function lidWijzigen($id) {
        /**
         * Zorgt ervoor dat een formulier wordt getoond om het geselecteerde lid te wijzigen.
         */
        if (!$this->authex->loggedIn()) {
            redirect('home/login');
        }

        $this->load->model('persoon_model');
        $data['lid'] = $this->persoon_model->get($id);
        $data['title'] = 'Lid wijzigen';
        $data['user'] = $this->authex->getUserInfo();
        $data['auteur'] = 'Stefanie Seker';

        $partials = array('header' => 'main_header', 'content' => 'lid_aanpassen', 'menu' => 'main_menu');
        $this->template->load('main_master', $partials, $data);
    }

    public function lidSchrappen($id) {
        /**
         * Zorgt ervoor dat het geselecteerde lid wordt verwijderd.
         */
        $this->load->model('persoon_model');
        $data['lid'] = $this->persoon_model->delete($id);
        $data['user'] = $this->authex->getUserInfo();

        redirect('/persoon/ledenOverzicht');
    }

    public function lidToevoegen() {
        /**
         * Zorgt ervoor dat er een formulier wordt getoond om een lid toe te voegen.
         */
        if (!$this->authex->loggedIn()) {
            redirect('home/login');
        }

        $data['title'] = 'Lid toevoegen';
        $data['auteur'] = 'Stefanie Seker';
        $data['lid'] = $this->getEmptyPersoon();
        $data['user'] = $this->authex->getUserInfo();

        $partials = array('header' => 'main_header', 'content' => 'lid_toevoegen', 'menu' => 'main_menu');
        $this->template->load('main_master', $partials, $data);
    }

    public function registreerLid() {
        /**
         * Zorgt ervoor dat de gegevens die ingegeven werden over een lid worden opgeslagen.
         */
        $lid = new stdClass();
        $lid->voornaam = strip_tags(ucfirst(strtolower($this->input->post('voornaam'))));
        $lid->naam = strip_tags(ucfirst(strtolower($this->input->post('naam'))));
        $lid->straat = strip_tags(ucfirst(strtolower($this->input->post('straat'))));
        $lid->huisnummer = strip_tags($this->input->post('huisnummer'));
        $lid->gemeente = strip_tags(ucfirst(strtolower($this->input->post('gemeente'))));
        $lid->land = strip_tags(ucfirst(strtolower($this->input->post('land'))));
        $lid->telefoon = strip_tags($this->input->post('telefoon'));
        $lid->email = strip_tags($this->input->post('email'));
        $lid->betaalstatus = strip_tags($this->input->post('betaalstatus'));
        $lid->theorieles = strip_tags($this->input->post('theorieles'));
        $lid->actief = strip_tags($this->input->post('actief'));
        $lid->id = strip_tags($this->input->post('hidden_id'));

        $lid->soort = 'Lid';
        $this->load->model('persoon_model');
        if ($lid->id == 0) {
            $last = $this->persoon_model->getLastRecordLidnummer();
            $lid->lidnummer = $last->lidnummer +1;
            
            $this->persoon_model->insert($lid);
        } else {
            $this->persoon_model->update($lid);
        }
        $this->ledenOverzicht();
    }
    
    public function lidgeldBetaaldReset()
    {
        /**
         * Zorgt ervoor dat voor alle personen de status van het ligeld op 'niet betaald' wordt gezet.
         */
        $this->load->model('persoon_model');
        $leden = $this->persoon_model->getAllLeden();
        
        foreach($leden as $lidje)
        {
            $lid = new stdClass();
            $lid->id = $lidje->id;
            $lid->betaalstatus = 0;
            $this->persoon_model->update($lid);
        }
        
        redirect('persoon/ledenOverzicht');
    }

    public function toggleActief($id, $actief) {
        /**
         * Zorgt ervoor dat de waarde van actief wordt aangepast naar het tegenovergestelde van de actief-waarde nu.
         */
        $lid = new stdClass();

        $lid->id = $id;
        if ($actief == '0') {
            $lid->actief = '1';
        } else {
            $lid->actief = '0';
        }
        $this->load->model('persoon_model');
        $this->persoon_model->update($lid);
        redirect('persoon/ledenOverzicht');
    }

    public function toggleTheorie($id, $theorie) {
        /**
         * Zorgt ervoor dat de waarde van theorie wordt aangepast naar het tegenovergestelde van de theorie-waarde nu.
         */
        $lid = new stdClass();

        $lid->id = $id;
        if ($theorie == '0') {
            $lid->theorieles = '1';
        } else {
            $lid->theorieles = '0';
        }
        $this->load->model('persoon_model');
        $this->persoon_model->update($lid);
        redirect('persoon/ledenOverzicht');
    }

    public function toggleBetaald($id, $betaald) {
        /**
         * Zorgt ervoor dat de waarde van betaalstatus wordt aangepast naar het tegenovergestelde van de betaalstatus-waarde nu.
         */
        $lid = new stdClass();

        $lid->id = $id;
        if ($betaald == '0') {
            $lid->betaalstatus = '1';
        }
        if ($betaald == '1') {
            $lid->betaalstatus = '0';
        }
        $this->load->model('persoon_model');
        $this->persoon_model->update($lid);
        redirect('persoon/ledenOverzicht');
    }

    public function beheerderWijzigen($id) {
        /**
         * Toont een formulier om de geselecteerde beheerder aan te passen.
         */
        if (!$this->authex->loggedIn()) {
            redirect('home/login');
        }

        $data['title'] = 'Hondenschool Bollie';
        $data['nobox'] = true;      // geen extra rand rond hoofdmenu
        $data['user'] = $this->authex->getUserInfo();
        $data['auteur'] = 'Jarne Peeters, Bart Buyens';

        $this->load->model('persoon_model');
        $data['beheerder'] = $this->persoon_model->get($id);

        $partials = array('header' => 'main_header', 'content' => 'beheerderAanpassen', 'menu' => 'main_menu');
        $this->template->load('main_master', $partials, $data);
    }

    public function wijzigBeheerder() {
        /**
         * Haalt de gegevens van het formulier op en slaat deze op in de database.
         */
        $beheerder = new stdClass();
        $beheerder->id = strip_tags($this->input->post('hidden_id'));
        $beheerder->voornaam = strip_tags($this->input->post('voornaam'));
        $beheerder->naam = strip_tags($this->input->post('naam'));
        $beheerder->email = strip_tags($this->input->post('email'));
        $beheerder->paswoord = sha1(strip_tags($this->input->post('paswoord')));

        $this->load->model('persoon_model');
        $this->persoon_model->update($beheerder);

        redirect('persoon/index');
    }

    public function beheerderSchrappen($id) {
        /**
         * Zorgt ervoor dat de geselecteerde beheerder wordt verwijderd.
         */
        $this->load->model('persoon_model');
        $data['beheerder'] = $this->persoon_model->delete($id);

        $this->load->model('persoon_model');
        $data['beheerder'] = $this->persoon_model->delete($id);
        $data['user'] = $this->authex->getUserInfo();
        $data['auteur'] = 'Jarne Peeters, Bart Buyens';

        redirect('/persoon/index');
    }

    public function beheerderToevoegen() {
        /**
         * Toont een formulier om een beheerder toe te voegen.
         */
        if (!$this->authex->loggedIn()) {
            redirect('home/login');
        }

        $data['title'] = 'Hondenschool Bollie';
        $data['nobox'] = true;      // geen extra rand rond hoofdmenu
        $data['user'] = $this->authex->getUserInfo();
        $data['auteur'] = 'Jarne Peeters, Bart Buyens';

        $partials = array('header' => 'main_header', 'content' => 'beheerderToevoegen', 'menu' => 'main_menu');
        $this->template->load('main_master', $partials, $data);
    }

    public function registreerBeheerder() {
        /**
         * Gegevens worden opgehaald uit het formulier en opgeslagen in de database.
         */
        $beheerder = new stdClass();
        $beheerder->voornaam = strip_tags($this->input->post('voornaam'));
        $beheerder->naam = strip_tags($this->input->post('naam'));
        $beheerder->email = strip_tags($this->input->post('email'));
        $beheerder->paswoord = sha1(strip_tags($this->input->post('paswoord')));
        $beheerder->soort = "Beheerder";
        $this->load->model('persoon_model');
        $data['beheerder'] = $this->persoon_model->insert($beheerder);

            redirect('persoon/index');
        }
       

    function getEmptyPersoon() {

        /**
         * Haalt een lege persoon op.
         */
        $persoon = new stdClass();

        $persoon->id = 0;
        $persoon->voornaam = '';
        $persoon->naam = '';
        $persoon->email = '';
        $persoon->actief = true;
        $persoon->telefoon = '';
        $persoon->land = '';
        $persoon->gemeente = '';
        $persoon->straat = '';
        $persoon->huisnummer = '';
        $persoon->lidnummer = '';
        $persoon->hondenschoolId = 0;
        $persoon->betaalstatus = false;
        $persoon->theorieles = false;
        $persoon->soort = '';
        $persoon->userId = 0;
        $persoon->paswoord = '';

        return $persoon;
    }
}

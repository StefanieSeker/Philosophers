<?php
/**
 * Created by PhpStorm.
 * User: stefanieseker
 * Date: 4/20/18
 * Time: 10:35 AM
 */

class Admin extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('notation');
        $this->load->helper('url');
        $this->load->helper('html');

        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        } else {
            $this->authex->getUserInfo();
        }
    }

    public function index()
    {

        $data['user']  = $this->authex->getUserInfo();
        $data['auteur'] = 'Stefanie Seker';
        $data['title'] = 'Admin panel';
        $data['nobox'] = true;

        $this->load->model('era_model');
        $data['eras'] = $this->era_model->getAll();

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'admin_panel');
        $this->template->load('main_master', $partials, $data);
    }

    public function createPhilosopher(){

        $philosopher = new stdClass();
        $philosopher->Name = strip_tags($this->input->post('Name'));
        $philosopher->Birthdate = strip_tags($this->input->post('Birthdate'));
        $philosopher->PlaceOfBirth = strip_tags($this->input->post('PlaceOfBirth'));
        $philosopher->DateOfDeath = strip_tags($this->input->post('DateOfDeath'));
        $philosopher->EraID = strip_tags($this->input->post('EraID'));

        $this->load->model('philosopher_model');
        $data['philosopher'] = $this->philosopher_model->insert($philosopher);

        redirect('home/index');
    }

}
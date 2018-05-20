<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('notation');
        $this->load->helper('url');
        $this->load->helper('html');
    }

    public function index()
    {
        $data['auteur'] = 'Stefanie Seker';
        $data['title'] = '';
        $data['nobox'] = true;
        $data['user'] = $this->authex->getUserInfo();

        $this->load->model('philosopher_model');
        $data['philosophers'] = $this->philosopher_model->getAll();

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'main_content');
        $this->template->load('main_master', $partials, $data);
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($this->authex->login($email, $password)) {
            redirect('admin/index');
        } else {
            redirect('home/index');
        }
    }

    public function logout() {

        $this->authex->logout();
        redirect('home/index');
    }

    public function getAjaxPhilosopherDetail(){
        $id = $this->input->get('philosopherId');

        $this->load->model('philosopher_model');
        $data['philosopher'] = $this->philosopher_model->get($id);

        $this->load->view("ajax_philosopher", $data);
    }

}
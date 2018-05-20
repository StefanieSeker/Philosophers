<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {


    public function __construct()
    {
        $CI = & get_instance();
        
        $CI->load->model('person_model');
    }

    function loggedIn() 
    {
        $CI = & get_instance();
        if ($CI->session->has_userdata('user_id')) {
            return true;
        } else {
            return false;
        }
    }
    
    function getUserInfo() 
    {
        $CI = & get_instance();
        if (! $this->loggedIn()) {
            return null;
        } else {
            $id = $CI->session->userdata('user_id');
            return $CI->person_model->get($id);
        }
    }

    function login($email, $password)
    {
        $CI = & get_instance();
        $user = $CI->person_model->getAccount($email, $password);
        if ($user == null) {
            return false;
        } else {
            $CI->session->set_userdata('user_id', $user->id);
            return true;
        }
    }

    function logout() 
    {
        $CI = & get_instance();
        $CI->session->unset_userdata('user_id');
    }

    function register($naam, $email, $password) 
    {
        $CI = & get_instance();
        if ($CI->person_model->emailVrij($email)) {
            $id = $CI->person_model->insert($naam, $email, $password);
            return $id;
        } else {
            return 0;
        }
    }
    
    function controleer($email)
    {
        $CI = & get_instance();
        if ($CI->person_model->emailVrij($email)) {
            return false;
        } else{
            return true;
        } 
    }
    
    function activate($id) 
    {
        $CI = & get_instance();
        $CI->person_model->activeer($id);
    }

}
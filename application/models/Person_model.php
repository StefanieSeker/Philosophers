<?php

/**
 * Description of Persoon_model
 *
 * @author StefanieS
 */
class Person_model extends CI_Model {
        
    function __construct()
    {
        parent::__construct();
    }
    
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('Person');
        return $query->row();
    }

    function getAll()
    {
        $this->db->order_by('Name', 'asc');
        $query = $this->db->get('Person');
        return $query->result();
    }
    
    function getByNaam($naam)
    {
        $this->db->where('Name', $naam);
        $query = $this->db->get('Person');
        return $query->row(); 
    }
    
    function insert($persoon)
    {
        $this->db->insert('Person', $persoon);
        return $this->db->insert_id();
    }
    
    function update($persoon)
    {
        $this->db->where('id', $persoon->id);
        $this->db->update('Person', $persoon);
    }
    
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('Person');
    }

    function getAccount($email, $password)
    {
        $this->db->where('Email', $email);
        $this->db->where('Password', $password);
        $query = $this->db->get('Person');
        echo $query;
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return null;
        }
    }
    
    function updatepaswoord($email, $paswoord)
    {
        $user = new stdClass();
        $user->password = sha1($paswoord);
        $this->db->where('Email',$email);
        $this->db->update('Person', $user);
    }
    
    function activeer($id)
    {
        $user = new stdClass();
        $user->geactiveerd = 1;
        $this->db->where('ID', $id);
        $this->db->update('Person', $user);
    }
}

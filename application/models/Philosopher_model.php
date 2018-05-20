<?php

class Philosopher_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('Philosopher');
        return $query->row();
    }

    function getAll()
    {
        $this->db->order_by('Name', 'asc');
        $query = $this->db->get('Philosopher');
        return $query->result();
    }

    function insert($philosopher)
    {
        $this->db->insert('Philosopher', $philosopher);
        return $this->db->insert_id();
    }

    function update($philosopher)
    {
        $this->db->where('id', $philosopher->ID);
        $this->db->update('Person', $philosopher);
    }

    function delete($id)
    {
        $this->db->where('ID', $id);
        $this->db->delete('Philosopher');
    }
}
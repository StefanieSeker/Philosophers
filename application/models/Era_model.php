<?php

class Era_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $this->db->where('ID', $id);
        $query = $this->db->get('Era');
        return $query->row();
    }

    function getAll()
    {
        $this->db->order_by('Era', 'asc');
        $query = $this->db->get('Era');
        return $query->result();
    }

    function insert($era)
    {
        $this->db->insert('Era', $era);
        return $this->db->insert_id();
    }

    function update($era)
    {
        $this->db->where('ID', $era->ID);
        $this->db->update('Era', $era);
    }

    function delete($id)
    {
        $this->db->where('ID', $id);
        $this->db->delete('Era');
    }
}
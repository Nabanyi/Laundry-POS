<?php
class Users_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_staff_name_by_args($args)
    {
        $this->db->select('firstname, lastname, middlename');
        $this->db->where($args);
        $query = $this->db->get('staff');
        return $query->row();
    }

    public function get_user_data($args)
    {
        $this->db->where($args);
        $this->db->limit(1);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function get_users()
    {
        $this->db->select('*');
        $query = $this->db->get('users');
        return $query->result();
    }

    public function update_user($data, $args)
    {
        $this->db->where($args);
        $this->db->limit(1);
        return $this->db->update('users', $data);
    }

    public function create_users($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function create_log($data)
    {
        return $this->db->insert('audit_logs', $data);
    }

    public function get_company()
    {
        $query = $this->db->get('company');
        return $query->row();
    }
}
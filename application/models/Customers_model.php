<?php
class Customers_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

	public function get_customers()
    {
        $this->db->select('*');
        $query = $this->db->get('customers');
        return $query->result();
    }

    public function update_customer($data, $args)
    {
        $this->db->where($args);
        $this->db->limit(1);
        return $this->db->update('customers', $data);
    }

    public function create_customer($data)
    {
        return $this->db->insert('customers', $data);
    }

    public function create_customer_id($data)
    {
        $this->db->insert('customers', $data);
        return $this->db->insert_id();
    }

    public function get_customer($args)
    {
        $this->db->where($args);
        $this->db->limit(1);
        $query = $this->db->get('customers');
        return $query->row();
    }

    public function search_customers($search)
    {
        $this->db->select("firstname, lastname, middlename, id");
        $this->db->like('firstname', $search);
        $this->db->or_like('lastname', $search);
        $this->db->or_like('middlename', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('email', $search);
        $this->db->limit(50);
        $query = $this->db->get('customers');
        return $query->result();
    }
}
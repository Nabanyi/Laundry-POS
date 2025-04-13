<?php
class Product_model extends CI_Model {

    public function insert($data) {
        return $this->db->insert('products', $data);
    }

    public function get_product_args($args)
    {
        $this->db->where($args);
        $this->db->limit(1);
        $query = $this->db->get('products');
        return $query->row();
    }

    public function get_products()
    {
        $this->db->select('*');
        $query = $this->db->get('products');
        return $query->result();
    }

    public function update_product($data, $args)
    {
        $this->db->where($args);
        $this->db->limit(1);
        return $this->db->update('products', $data);
    }
}
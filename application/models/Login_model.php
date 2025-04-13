<?php
class Login_model extends CI_Model {
    
    public function get_user($args) {
        $this->db->where($args);
        $query = $this->db->get('users');
        return $query->row();
    }
}
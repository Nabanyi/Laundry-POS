<?php
class Orders_model extends CI_Model {

    public function get_order_args($args)
    {
        $this->db->where($args);
        $this->db->limit(1);
        $query = $this->db->get('orders');
        return $query->row();
    }

    public function get_orders_args($args)
    {
        $this->db->select('*');
        $this->db->where($args);
        $this->db->where('active', '1');
        $query = $this->db->get('orders');
        return $query->result();
    }

    public function get_dashboard_orders()
    {
        $this->db->select('*');
        $this->db->where('active', '1');
        $this->db->order_by('id', 'desc');
        $this->db->limit(20);
        $query = $this->db->get('orders');
        return $query->result();
    }

    public function generate_orderid()
    {
        $id = '';
        for ($i=0; $i < 12; $i++) {
            $id .= mt_rand(0, 9);
        }

        while (!empty($this->get_order_args( ['orderid'=>$id] ))) {
            $id = '';
            for ($i=0; $i < 12; $i++) {
                $id .= mt_rand(0, 9);
            }
        }

        return $id;
    }

    public function create_order_items($data)
    {
        return $this->db->insert_batch('order_items', $data);
    }

    public function create_order($data)
    {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    public function get_order_items($args)
    {
        $this->db->select('*');
        $this->db->where($args);
        $query = $this->db->get('order_items');
        return $query->result();
    }

    public function update_order($data, $args)
    {
        $this->db->where($args);
        return $this->db->update('orders', $data);
    }

    public function create_payment($data)
    {
        return $this->db->insert('payment_logs', $data);
    }

    public function count_sales()
    {
        $this->db->select("count(*) as count");
        $this->db->where(['status'=>'3']);
        $query = $this->db->get('orders');
        return $query->row();
    }

    public function count_items()
    {
        $this->db->select("count(*) as count");
        $query = $this->db->get('products');
        return $query->row();
    }

    public function count_users()
    {
        $this->db->select("count(*) as count");
        $query = $this->db->get('users');
        return $query->row();
    }

    public function count_pending_orders()
    {
        $this->db->select("count(*) as count");
        $this->db->where(['status'=>'0']);
        $query = $this->db->get('orders');
        return $query->row();
    }
}
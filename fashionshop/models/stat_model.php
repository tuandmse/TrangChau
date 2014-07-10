<?php
/**
 * Created by PhpStorm.
 * User: blues
 * Date: 6/3/14
 * Time: 9:25
 */

class Stat_model extends CI_Model
{

    function get_first_date_in_order($pid)
    {
        $this->db->select('ordered_on');
        $this->db->join('orders', 'orders.id=order_items.order_id', 'right');
        $this->db->where('product_id', $pid);
        $this->db->limit(1, 0);
        $result = $this->db->get('order_items')->result();

        return $result;
    }
} 
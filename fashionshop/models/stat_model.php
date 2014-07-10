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

    function get_stat_for_a_month($pid, $i_year, $i_month){
        $this->db->select('day(ordered_on) as day, sum(quantity) as quantity');
//        $this->db->distinct('day(ordered_on)');
        $this->db->join('orders', 'orders.id=order_items.order_id', 'right');
        $this->db->where('product_id', $pid);
        $this->db->where('year(ordered_on)', $i_year);
        $this->db->where('month(ordered_on)', $i_month);
        $this->db->group_by('day(ordered_on)');
        $result = $this->db->get('order_items')->result();

        return $result;
    }
} 
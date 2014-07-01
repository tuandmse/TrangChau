<?php
/**
 * Created by PhpStorm.
 * User: blues
 * Date: 6/3/14
 * Time: 9:25
 */

class Rate_and_comment_model extends CI_Model
{

    function get_all_rates($pid)
    {
        $this->db->select('email, content, rate.id, rate');
        $this->db->join('customers', 'customers.id=rate.user_id', 'right');
        $this->db->where('product_id', $pid);
        $result = $this->db->get('rate')->result();

        $customer = $this->go_cart->customer();
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]->email == $customer['email']) {
                $result[$i]->is_my_rate = true;
            } else {
                $result[$i]->is_my_rate = false;
            }
        }

        return $result;
    }

    function rate($pid, $uid, $star, $content)
    {
        $rate['product_id'] = $pid;
        $rate['user_id'] = $uid;
        $rate['rate'] = $star;
        $rate['content'] = $content;
        $this->db->delete('rate', array('product_id' => $pid, 'user_id' => $uid));
        $this->db->insert('rate', $rate);
    }

    function delete_rate($cid)
    {
        $this->db->delete('rate', array('id' => $cid));
    }
} 
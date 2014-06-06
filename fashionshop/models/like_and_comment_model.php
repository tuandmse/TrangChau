<?php
/**
 * Created by PhpStorm.
 * User: blues
 * Date: 6/3/14
 * Time: 9:25
 */

class Like_and_comment_model extends CI_Model
{

    function get_all_comment($pid)
    {
        $this->db->select('email, content, comment.id');
        $this->db->join('customers', 'customers.id=comment.user_id', 'right');
        $this->db->where('product_id', $pid);
        $result	= $this->db->get('comment')->result();

        $customer = $this->go_cart->customer();
        for($i = 0; $i < count($result); $i ++){
            if($result[$i]->email == $customer['email']){
                $result[$i]->is_my_comment = true;
            } else {
                $result[$i]->is_my_comment = false;
            }
        }

        return $result;
    }

    function get_a_comment($cid)
    {
        $this->db->where('id', $cid);
        $result	= $this->db->get('comment')->result();

        return $result;
    }

    function count_all_like($pid)
    {
        $this->db->where('product_id', $pid);
        $result = $this->db->count_all_results('like');

        return $result;
    }

    function like($pid, $uid)
    {
        $like['product_id'] = $pid;
        $like['user_id'] = $uid;
        $this->db->insert('like', $like);
    }

    function is_like($pid, $uid)
    {
        $this->db->where('product_id', $pid);
        $this->db->where('user_id', $uid);
        $result = $this->db->count_all_results('like');
        if($result == 0){
            return false;
        } else {
            return true;
        }
    }

    function unlike($pid, $uid)
    {
        $this->db->delete('like', array('product_id'=>$pid,'user_id'=>$uid));
    }

    function comment($pid, $uid, $content)
    {
        $comment['product_id'] = $pid;
        $comment['user_id'] = $uid;
        $comment['content'] = $content;
        $this->db->insert('comment', $comment);
    }

    function delete_comment($cid)
    {
        $this->db->delete('comment', array('id'=>$cid));
    }
} 
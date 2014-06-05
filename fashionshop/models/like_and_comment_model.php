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
        $result	= $this->db->get('comment');

        return $result->result();
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
} 
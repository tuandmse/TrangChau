<?php
/**
 * Created by PhpStorm.
 * User: blues
 * Date: 6/3/14
 * Time: 9:56
 */

class Like_and_comment extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Like_and_comment_model'));
        $this->load->helper('form');
    }

    function like($pid)
    {
        $customer = $this->go_cart->customer();
        $this->Like_and_comment_model->like($pid, $customer['id']);
        redirect($_SERVER['HTTP_REFERER']);
    }

    function unlike($pid)
    {
        $customer = $this->go_cart->customer();
        $this->Like_and_comment_model->unlike($pid, $customer['id']);
        redirect($_SERVER['HTTP_REFERER']);
    }

    function comment($pid)
    {
        $content = $this->input->post('content');
        if($content != ''){
            $customer = $this->go_cart->customer();
            $this->Like_and_comment_model->comment($pid, $customer['id'], $content);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    function delete_comment($cid)
    {
        if($this->session->userdata('admin')){
            $this->Like_and_comment_model->delete_comment($cid);
        } else {
            $customer = $this->go_cart->customer();
            $comment = $this->Like_and_comment_model->get_a_comment($cid);
            if($customer['id'] == $comment[0]->user_id){
                $this->Like_and_comment_model->delete_comment($cid);
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: blues
 * Date: 6/3/14
 * Time: 9:56
 */

class Rate_and_comment extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Rate_and_comment_model'));
        $this->load->helper('form');
    }

    function rate($pid)
    {
        $star = $this->input->post('rating');
        $content = $this->input->post('content');
        $customer = $this->go_cart->customer();
        $this->Rate_and_comment_model->rate($pid, $customer['id'], $star, $content);
        redirect($_SERVER['HTTP_REFERER']);
    }

    function delete_rate($cid)
    {
        if ($this->session->userdata('admin')) {
            $this->Rate_and_comment_model->delete_rate($cid);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

} 